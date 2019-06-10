<?php

namespace khans\utils\tools\models;

use Yii;
use \khans\utils\models\queries\KHanQuery;


/**
 * This is the model class for table "sys_history_emails".
 *
 * @property string $tableComment تاریخچه ارسال ایمیل خودکار گردش کار
 *
 * @property string $id شناسه جدول
 * @property string $responsible_model مدل/حدول فعال کننده ایمیل
 * @property string $responsible_record رکورد مرتبط در جدول
 * @property string $workflow_transition انتقال گردش کار انجام شده
 * @property string $workflow_start آغاز گردش کار
 * @property string $workflow_end پایان گردش کار
 * @property string $content متن ایمیل
 * @property string $user_id شناسه کاربر تغییر دهنده گردش کار
 * @property int $enqueue_timestamp زمان افزایش به صف ارسال
 * @property string $recipient_id شناسه گیرنده
 * @property string $recipient_email ایمیل گیرنده
 * @property string $cc_receivers ایمیل گیرندگان رونوشت
 * @property string $attachments نام فایلهای پیوست
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */
class SysHistoryEmails extends \khans\utils\models\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'تاریخچه ارسال ایمیل خودکار گردش کار';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_history_emails';
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['responsible_model', 'responsible_record', 'workflow_start', 'workflow_end', 'content', 'user_id', 'enqueue_timestamp', 'recipient_id', 'recipient_email', 'cc_receivers', 'attachments'], 'required'],
            [['content'], 'string'],
            [['enqueue_timestamp'], 'integer'],
            [['responsible_model', 'responsible_record', 'workflow_transition', 'workflow_start', 'workflow_end', 'user_id', 'recipient_id', 'recipient_email', 'cc_receivers', 'attachments'], 'string', 'max' => 127],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
            'id' => 'شناسه جدول',
            'responsible_model' => 'مدل/حدول فعال کننده ایمیل',
            'responsible_record' => 'رکورد مرتبط در جدول',
            'workflow_transition' => 'انتقال گردش کار انجام شده',
            'workflow_start' => 'آغاز گردش کار',
            'workflow_end' => 'پایان گردش کار',
            'content' => 'متن ایمیل',
            'user_id' => 'کاربر تغییر دهنده گردش کار',
            'enqueue_timestamp' => 'زمان افزایش به صف ارسال',
            'recipient_id' => 'شناسه گیرنده',
            'recipient_email' => 'ایمیل گیرنده',
            'cc_receivers' => 'ایمیل گیرندگان رونوشت',
            'attachments' => 'نام فایلهای پیوست',
        ];
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
     * @return \khans\utils\tools\models\queries\SysHistoryEmailsQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new \khans\utils\tools\models\queries\SysHistoryEmailsQuery(get_called_class());
    }
}
