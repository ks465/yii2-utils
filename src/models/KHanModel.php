<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 11:46
 */


namespace khans\utils\models;

use khans\utils\components\{Jalali, ViewHelper, ArrayHelper};
use khans\utils\tools\models\SysHistoryDatabase;
use Yii;
use yii\behaviors\{BlameableBehavior, TimestampBehavior};
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class KHanModel holds the basic structure of all database models.
 * Thus it is marked as `abstract` to avoid instantiating a model without table.
 *
 * @property integer $status     وضعیت فعال بودن رکورد
 * @property integer $created_by سازنده رکورد
 * @property integer $created_at زمان ساخت رکورد
 * @property integer $updated_by آخرین ویراینده رکورد
 * @property integer $updated_at زمان آخرین ویرایش رکورد
 * @property string  $workflowID
 *
 * @method bool enterWorkflow(string $string)
 * @method bool sendToStatus(string $string)
 * @method bool statusEquals(string $string)
 * @method \raoul2000\workflow\base\Status getWorkflowStatus()
 * @method \raoul2000\workflow\base\WorkflowInterface getWorkflow()
 * @method \raoul2000\workflow\base\Workflow getWorkflowSource()
 * @method mixed getMetaData(string $string, mixed $defaultValue)
 * @method mixed getStatusesLabels()
 * @method mixed getWorkflowState()
 *
 * @package khans\utils
 * @version 0.4.14-980416
 * @since   1.0
 */
class KHanModel extends ActiveRecord
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = '';
    /**
     * record is marked as deleted -- destroyed -- and users can not see it at all
     */
    const STATUS_DELETED = 0;
    /**
     * Record is disabled to be used in new transactions. But previous data can access the details for read-only access.
     */
    const STATUS_ARCHIVED = 2;
    /**
     * Record is disabled to be used in new transactions. But previous data can access the details for read-only access.
     */
    const STATUS_PENDING = 4;
    /**
     * record is active and user can do whatever allowed
     */
    const STATUS_ACTIVE = 10;
    /**
     * @var array $_statuses list of available statuses for users
     */

    private static $_statuses = [
        KHanModel::STATUS_DELETED => 'پاک شده',
        KHanModel::STATUS_PENDING => 'معلق',
        KHanModel::STATUS_ACTIVE  => 'فعال',
    ];

    /**
     * @return string
     */
    public static function getTableComment(): string
    {
        if(empty(static::$tableComment)){
            return static::tableName();
        }
        return static::$tableComment;
    }
    /**
     * Show a string representation of boolean fields instead of 0/1
     *
     * @param string $attribute name of attribute which is boolean
     *
     * @return string
     */
    public function getBooleanView($attribute)
    {
        if (is_null($this->{$attribute})) {
            return '<i class="glyphicon glyphicon-question-sign text-warning"> </i>';
        }

        return $this->{$attribute} ? '<i class="glyphicon glyphicon-ok text-success"> </i>' : '<i class="glyphicon glyphicon-remove text-danger"> </i>';
    }

    /**
     * Convert array of model's errors into string for display
     *
     * @return string
     */
    public function getModelErrors(): string
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[] = ViewHelper::implode($error, '<br />');
        }

        return implode('<br />', $errors);
    }

    /**
     * get the title for status of the given record or value
     *
     * @param null|integer $status current status id
     *
     * @return string label for the status
     */
    public function getStatus($status = null): string
    {
        if (empty($status)) {
            return ArrayHelper::getValue(static::getStatuses(), $this->status, 'نامشخص');
        }

        return ArrayHelper::getValue(static::getStatuses(), $status, 'نامشخص');
    }

    /**
     * get list of available statuses defined.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return static::$_statuses;
    }

    /**
     * Return labels for the model
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'status'     => 'وضعیت',
            'created_by' => 'سازنده',
            'created_at' => 'زمان ساخت',
            'updated_by' => 'آخرین ویرایشگر',
            'updated_at' => 'زمان آخرین ویرایش',
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     * Add timestamp and blameable behavior to inhabitant
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'blameable' => [
                'class'              => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'history'   => [
                'class'          => \nhkey\arh\ActiveRecordHistoryBehavior::class,
                'ignoreFields'   => ['created_at', 'created_by', 'updated_at', 'updated_by'],
                'managerOptions' => ['tableName' => 'sys_history_database'],
            ],
        ];
    }

    /**
     *Creates an [[queries\KHanQuery]] instance for query purpose.
     *
     * @return queries\KHanQuery the active query used by this AR class.
     */
    public static function find(): queries\KHanQuery
    {
        return new queries\KHanQuery(get_called_class());
    }

    /**
     * Mark the record as deleted
     */
    public function delete(): void
    {
        $this->setAttribute('status', self::STATUS_DELETED);
        $this->save();
    }

//    /**
//     * @param bool  $runValidation whether to perform validation (calling [[validate()]]) before saving the record.
//     *     Defaults to `true`. If the validation fails, the record will not be saved to the database and this method
//     *     will return `false`.
//     * @param array $attributeNames list of attribute names that need to be saved. Defaults to null, meaning all
//     *     attributes that are loaded from DB will be saved.
//     *
//     * @return bool whether the saving succeeded (i.e. no validation errors occurred).
//     */
//    public function save($runValidation = true, $attributeNames = null): bool
//    {
//        if ($this->validate()) {
//            Yii::$app->session->addFlash('success', 'Model saved successfully.');
//
//            return parent::save(false, $attributeNames);
//        } else {
//            Yii::$app->session->addFlash('error', $this->getModelErrors());
//
//            return false;
//        }
//    }

    /**
     * Check the record is marked as [[KHanModel::STATUS_ACTIVE]].
     * All records are always active for `Super Admin`
     *
     * @return bool true if record is marked as active or the current user is `Super Admin`
     */
    public function isActive(): bool
    {
        if (property_exists(Yii::$app, 'user') && Yii::$app->user->isSuperAdmin) {
            return true;
        }

        return $this->status === KHanModel::STATUS_ACTIVE;
    }

    /**
     * Check the record is marked as anything other than [[KHanModel::STATUS_DELETED]].
     * All records are always visible to `Super Admin`
     *
     * @return bool true if record is not marked as deleted or the current user is `Super Admin`
     */
    public function isVisible(): bool
    {
        if (property_exists(Yii::$app, 'user') && Yii::$app->user->isSuperAdmin) {
            return true;
        }

        return $this->status !== KHanModel::STATUS_DELETED;
    }

    /**
     * Get active record for the creator of the record from the given user table
     *
     * @return IdentityInterface
     */
    public function getCreator(): ?IdentityInterface
    {
        return $this->getResponsibleUser($this->created_by);
    }

    /**
     * Get active record for the given user id in all of the instances of [[UserTable]] or [[UserArray]].
     * If the given id can not be found, an empty model will be returned.
     * This method should be overridden by the child classes to meet their structure requirements.
     *
     * @param integer $ownerID requested Id
     *
     * @return IdentityInterface
     */
    protected function getResponsibleUser(int $ownerID): ?IdentityInterface
    {
        return Yii::$app->user->identityClass::findOne($ownerID);
    }

    /**
     * Get active record for the updater of the record from the given user table
     *
     * @return IdentityInterface
     */
    public function getUpdater(): ?IdentityInterface
    {
        return $this->getResponsibleUser($this->updated_by);
    }

    /**
     * Get complete date and time of creating the record
     *
     * @return string
     */
    public function getCreatedTime(): string
    {
        return Jalali::date(Jalali::KHAN_LONG, $this->created_at);
    }

    /**
     * Get complete date and time of updating the record
     *
     * @return string
     */
    public function getUpdatedTime(): string
    {
        return Jalali::date(Jalali::KHAN_LONG, $this->updated_at);
    }

    /**
     * Return the timestamp of last activity for workflow status of the given record
     *
     * @return integer value of the latest activity in [[updated_at]] field
     */
    public function getLastFlow(): int
    {
        return $this->updated_at;
    }

    /**
     * Get list of recorded history for this record, and include the EAV attributes.
     */
    public function getActionHistory()
    {
        $eavListQuery = new \yii\db\Query();
        $eavListQuery
            ->select(['val.id'])
            ->from(['attr'=> SysEavAttributes::tableName()])
            ->leftJoin(['val'=>SysEavValues::tableName()], 'val.attribute_id = attr.id')
            ->andWhere(['record_id' => $this->primaryKey])
            ->andWhere(['entity_table' => static::tableName()]);

        $sql = SysHistoryDatabase::find()
            ->orWhere(['and',
                ['table' => static::tableName()],
                ['field_id' => $this->primaryKey]
            ]);

        $sql->orWhere(['field_id' => $eavListQuery]);

        return $sql;
    }
}
