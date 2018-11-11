<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 11:46
 */


namespace KHanS\Utils\models;


use KHanS\Utils\components\Jalali;
use KHanS\Utils\components\ViewHelper;
use KHanS\Utils\Settings;
use Yii;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class KHanModel holds the basic structure of all database models.
 * Thus it is marked as `abstract` to avoid instantiating a model without table.
 *
 * @package KHanS\Utils
 * @version 0.4-970803
 * @since   1.0
 *
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
        KHanModel::STATUS_DELETED => 'غیرفعال',
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
    public static function getModelErrors(KHanModel $model)
    {
        $errors = $model->errors;
        foreach ($errors as &$error) {
            $error = ViewHelper::implode($error, '<br />');
        }

        return implode('<br />', $errors);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status'     => 'وضعیت',
            'created_by' => 'سازنده',
            'created_at' => 'زمان ساخت',
            'updated_by' => 'آخرین ویراینده',
            'updated_at' => 'زمان آخرین ویرایش',
        ];
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
        if (Yii::$app->user->isSuperAdmin) {
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
        if (Yii::$app->user->isSuperAdmin) {
            return true;
        }

        return $this->status !== KHanModel::STATUS_DELETED;
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
     * Get active record for the creator of the record from the given user table
     *
     * @param Model|ActiveRecord $ownerModel the class responsible for holding data of the log-ins to the applications.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator($ownerModel)
    {
        return $this->hasOne($ownerModel::className(), ['id' => 'created_by']);
    }

    /**
     * Get active record for the updater of the record from the given user table
     *
     * @param Model|ActiveRecord $ownerModel the class responsible for holding data of the log-ins to the applications.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater($ownerModel)
    {
        return $this->hasOne($ownerModel::className(), ['id' => 'updated_by']);
    }

    /**
     * Get complete date and time of creating the record
     *
     * @return string
     */
    public function getCreatedTime()
    {
        return Jalali::date(Settings::DATE_LONG_DATE_TIME, $this->created_at);
    }

    /**
     * Get complete date and time of updating the record
     *
     * @return string
     */
    public function getUpdatedTime()
    {
        return Jalali::date(Settings::DATE_LONG_DATE_TIME, $this->updated_at);
    }

    function upsert($rows)
    {
//echo '<pre dir="ltr">';var_dump($rows);echo '</pre>';
        foreach ($rows as $row) {
            /* @var UpsertData $row */
            $aggrQuery = UpsertAggr::find()
                ->andWhere(['grade' => $row['grade']])
                ->andWhere(['year' => $row['year']])
                ->andWhere(['field' => $row['field']])
                ->andWhere(['status' => $row['status']]);

            if ($aggrQuery->exists()) {
                $upsert = $aggrQuery->one();
//var_dump('Updating');
            } else {
                $upsert = new UpsertAggr();
//var_dump('Inserting');
            }

            $upsert->load($row, '');
//$upsert->validate();
//var_dump($upsert->errors);
            $upsert->save();
        }
    }
}