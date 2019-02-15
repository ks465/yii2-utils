<?php


namespace khans\utils\tools\models;

use khans\utils\components\ArrayHelper;
use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_history_users".
 *
 * @property string $id شناسه جدول
 * @property string $username شناسه ورود
 * @property int    $timestamp زمان رویداد
 * @property string $date تاریخ رویداد
 * @property string $time ساعت رویداد
 * @property int    $result نتیجه تلاش
 * @property int    $attempts تعداد تلاش
 * @property string $ip آی‌پی کاربر
 * @property string $user_id شناسه کاربر
 * @property string $user_table جدول کاربران
 *
 * @package KHanS\Utils
 * @version 0.1.1-971030
 * @since   1.0
 */
class SysHistoryUsers extends \khans\utils\models\KHanModel
{
    /**
     * Event results of history to the AR object (insert, update, delete or update primary key)
     */
    const LOGIN_FAILED = 0;
    const LOGIN_SUCCESSFUL = 1;

    /**
     * @var array list of event types in this context
     */
    private static $eventTypes = [
        self::LOGIN_FAILED     => 'ناکام',
        self::LOGIN_SUCCESSFUL => 'پیروز',
    ];

    /**
     * Get list of event types in this context along with their labels
     *
     * @return array
     */
    public static function getEventTypes(): array
    {
        return self::$eventTypes;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_history_users';
    }

    /**
     * Disable all behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['username', 'timestamp', 'result', 'attempts', 'ip', 'user_id', 'user_table'], 'required'],
            [['timestamp', 'result', 'attempts'], 'integer'],
            [['username', 'user_id', 'user_table'], 'string', 'max' => 127],
            [['date', 'time'], 'string', 'max' => 10],
            [['ip'], 'string', 'max' => 16],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'         => 'شناسه جدول',
            'username'   => 'شناسه ورود',
            'timestamp'  => 'زمان رویداد',
            'date'       => 'تاریخ رویداد',
            'time'       => 'ساعت رویداد',
            'result'     => 'نتیجه تلاش',
            'attempts'   => 'تعداد تلاش',
            'ip'         => 'آی‌پی کاربر',
            'user_id'    => 'شناسه کاربر',
            'user_table' => 'جدول کاربران',
        ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysHistoryUsersQuery the active query used by this AR class.
     */
    public static function find(): KHanQuery
    {
        return new queries\SysHistoryUsersQuery(get_called_class());
    }

    /**
     * Get label for the event types in this model
     *
     * @return string
     */

    public function getEventType()
    {
        return ArrayHelper::getValue(self::$eventTypes, $this->result, 'ناشناخته');
    }
}
