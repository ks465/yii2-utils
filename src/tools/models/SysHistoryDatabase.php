<?php


namespace khans\utils\tools\models;

use khans\utils\components\ArrayHelper;
use khans\utils\components\Jalali;
use khans\utils\models\KHanIdentity;
use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_history_database".
 *
 * @property string $id شناسه جدول
 * @property string $user_id کاربر ویراینده
 * @property string $date تاریخ رویداد
 * @property string $table جدول مرتبط
 * @property string $field_name فیلد ویرایش شده
 * @property string $field_id شناسه رکورد
 * @property string $old_value پیش از ویرایش
 * @property string $new_value پس از ویرایش
 * @property int    $type گونه ویرایش
 *
 * @package KHanS\Utils
 * @version 0.2.0-971114
 * @since   1.0
 */
class SysHistoryDatabase extends \khans\utils\models\KHanModel
{
    /**
     * Event types of history to the AR object (insert, update, delete or update primary key)
     */
    const AR_INSERT = 0;
    const AR_UPDATE = 1;
    const AR_DELETE = 2;
    const AR_UPDATE_PK = 3;

    /**
     * @var array list of event types in this context
     */
    private static $eventTypes = [
        self::AR_INSERT    => 'افزودن رکورد',
        self::AR_UPDATE    => 'ویرایش داده',
        self::AR_DELETE    => 'پاک کردن',
        self::AR_UPDATE_PK => 'ویرایش کلید',
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
        return 'sys_history_database';
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
            [['user_id', 'date', 'table', 'field_name', 'field_id', 'type'], 'required'],
            [['date'], 'safe'],
            [['old_value', 'new_value'], 'string'],
            [['type'], 'integer'],
            [['user_id'], 'string', 'max' => 127],
            [['table', 'field_name', 'field_id'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'         => 'شناسه جدول',
            'user_id'    => 'کاربر ویراینده',
            'date'       => 'تاریخ رویداد',
            'table'      => 'جدول مرتبط',
            'field_name' => 'فیلد ویرایش شده',
            'field_id'   => 'شناسه رکورد',
            'old_value'  => 'پیش از ویرایش',
            'new_value'  => 'پس از ویرایش',
            'type'       => 'گونه ویرایش',
        ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysHistoryDatabaseQuery the active query used by this AR class.
     */
    public static function find(): KHanQuery
    {
        return new queries\SysHistoryDatabaseQuery(get_called_class());
    }

    /**
     * Convert date from Gregorian to Jalali
     */
    public function afterFind()
    {
        try {
            $x = new \DateTime($this->date);
            $this->date = Jalali::date('Y/m/d H:i:s', $x->getTimestamp());
        } catch (\Exception $e) {
        }
        parent::afterFind();
    }

    /**
     * Get label for the event types in this model
     *
     * @return string
     */
    public function getEventType()
    {
        return ArrayHelper::getValue(self::$eventTypes, $this->type, 'ناشناخته');
    }

    /**
     * Get active record for the updater of the record from the given user table
     *
     * @return KHanIdentity
     */
    public function getUser(): string
    {
        return ArrayHelper::getValue($this->getResponsibleUser((int)$this->user_id), 'fullName', '?' . $this->user_id);
    }
}
