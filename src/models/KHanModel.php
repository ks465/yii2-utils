<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 11:46
 */


namespace khans\utils\models;


use khans\utils\components\{Jalali, ViewHelper};
use Yii;
use yii\behaviors\{BlameableBehavior, TimestampBehavior};
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class KHanModel holds the basic structure of all database models.
 * Thus it is marked as `abstract` to avoid instantiating a model without table.
 *
 * @package khans\utils
 * @version 0.4.4-971008
 * @since   1.0
 * @property integer $status     وضعیت فعال بودن رکورد
 * @property integer $created_by سازنده رکورد
 * @property integer $created_at زمان ساخت رکورد
 * @property integer $updated_by آخرین ویراینده رکورد
 * @property integer $updated_at زمان آخرین ویرایش رکورد
 */
abstract class KHanModel extends ActiveRecord
{
    /**
     * record is marked as deleted -- destroyed -- and users can not see it at all
     */
    const STATUS_DELETED = 0;
    /**
     * Record is disabled to be used in new transactions. But previous data can access the details for read-only access.
     */
    const STATUS_PENDING = 5;
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
     * Convert array of model's errors into string for display
     *
     * @param KHanModel $model
     *
     * @return string
     */
    public function getModelErrors()
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
    public function getStatus($status = null)
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
    public static function getStatuses()
    {
        return KHanModel::$_statuses;
    }

    /**
     * Return labels for the model
     *
     * @return array
     */
    public function attributeLabels()
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
     */
    public function behaviors()
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
                'class'              => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
//            'history'   => [
//                'class'        => \nhkey\arh\ActiveRecordHistoryBehavior::className(),
//                'ignoreFields' => ['created_at', 'created_by', 'updated_at', 'updated_by'],
//            ],
        ];
    }

    /**
     *Creates an [[queries\KHanQuery]] instance for query purpose.
     *
     * @return queries\KHanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new queries\KHanQuery(get_called_class());
    }

    /**
     * Mark the record as deleted
     */
    public function delete()
    {
        $this->setAttribute('status', self::STATUS_DELETED);
        $this->save();
    }

    /**
     * Check the record is marked as [[KHanModel::STATUS_ACTIVE]].
     * All records are always active for `Super Admin`
     *
     * @return bool true if record is marked as active or the current user is `Super Admin`
     */
    public function isActive()
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
    public function isVisible()
    {
        if (property_exists(Yii::$app, 'user') && Yii::$app->user->isSuperAdmin) {
            return true;
        }

        return $this->status !== KHanModel::STATUS_DELETED;
    }

    /**
     * Get active record for the creator of the record from the given user table
     *
     * @return KHanIdentity
     */
    public function getCreator()
    {
        return $this->getResponsibleUser($this->created_by);
    }

    /**
     * Get active record for the given user id in all of the instances of [[KHanIdentity]].
     * If the given id can not be found, an empty model will be returned.
     * This method should be overridden in the child classes to meet their structure requirements.
     *
     * @param integer $ownerID requested Id
     *
     * @return KHanIdentity
     */
    protected abstract function getResponsibleUser($ownerID);

    /**
     * Get active record for the updater of the record from the given user table
     *
     * @return KHanIdentity
     */
    public function getUpdater()
    {
        return $this->getResponsibleUser($this->updated_by);
    }

    /**
     * Get complete date and time of creating the record
     *
     * @return string
     */
    public function getCreatedTime()
    {
        return Jalali::date(Jalali::KHAN_LONG, $this->created_at);
    }

    /**
     * Get complete date and time of updating the record
     *
     * @return string
     */
    public function getUpdatedTime()
    {
        return Jalali::date(Jalali::KHAN_LONG, $this->updated_at);
    }

    /**
     * Return the timestamp of last activity for workflow status of the given record
     *
     * @return integer value of the latest activity in [[updated_at]] field
     */
    public function getLastFlow()
    {
        return $this->updated_at;
    }
}
