<?php

namespace khans\utils\helpers\migrations;



use khans\utils\tools\models\SysHistoryDatabase;
use khans\utils\tools\models\SysHistoryUsers;

/**
 * Class m190128_152310_CreateHistoryTables creates tables containing history of login and changes in records
 *
 * @package KHanS\Utils
 * @version 0.2.1-980219
 * @since   1.0
 */
class m190128_152310_CreateHistoryTables extends KHanMigration
{
    /**
     * @var string table containing history of login
     */
    protected $loginTable;
    /**
     * @var string table containing history of editing records all around the database
     */
    protected $historyTable;
    /**
     *
     * @var string table containing history of sent emails
     */
    protected $emailsTable;

    /**
     * Set name of tables to values set in the models
     */
    public function init()
    {
        $this->loginTable   = SysHistoryUsers::tableName();
        $this->historyTable   = SysHistoryDatabase::tableName();
        $this->emailsTable = \khans\utils\tools\models\SysHistoryEmails::tableName();
        
        parent::init();
    }

    /**
     * Remove indexes and two tables
     */
    public function safeDown()
    {
        $this->dropTable($this->loginTable);
        $this->dropTable($this->historyTable);
        $this->dropTable($this->emailsTable);
    }

    /**
     * Define the two tables and indexes
     */
    public function safeUp()
    {
        $this->createHistoryTable();
        $this->createLogsTable();
        $this->createEmailsTable();
    }

    private function createHistoryTable()
    {
        $fields = [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('شناسه جدول'),
            'user_id'=> $this->string(127)->notNull()->comment('کاربر ویراینده'),
            'date' => $this->datetime()->notNull()->comment('تاریخ رویداد'),
            'table' => $this->string(255)->notNull()->comment('جدول مرتبط'),
            'field_name' => $this->string()->notNull()->comment('فیلد ویرایش شده'),
            'field_id' => $this->string()->notNull()->comment('شناسه رکورد'),
            'old_value' => $this->text()->comment('پیش از ویرایش'),
            'new_value' => $this->text()->comment('پس از ویرایش'),
            'type' => $this->smallInteger()->notNull()->comment('گونه ویرایش'),
        ];
        $this->createTable($this->historyTable, $fields, $this->comment('تاریخچه ویرایش رکوردهای جدولهای سامانه'));

        $this->createIndex('idx-history-user_id', $this->historyTable, 'user_id');
        $this->createIndex('idx-history-table', $this->historyTable, 'table');
        $this->createIndex('idx-history-field_name', $this->historyTable, 'field_name');
        $this->createIndex('idx-history-type', $this->historyTable, 'type');
    }

    private function createLogsTable()
    {
        $fields = [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('شناسه جدول'),
            'username' => $this->string(127)->notNull()->comment('شناسه ورود'),
            'timestamp' => $this->bigInteger()->notNull()->comment('زمان رویداد'),
            'date'=>$this->latinChar(10)->comment('تاریخ رویداد'),
            'time'=>$this->latinChar(10)->comment('ساعت رویداد'),
            'result' => $this->bit()->notNull()->comment('نتیجه تلاش'),
            'attempts' => $this->tinyInteger(2)->notNull()->comment('تعداد تلاش'),
            'ip' => $this->latinChar(16)->notNull()->comment('آی‌پی کاربر'),
            'user_id'=> $this->string(127)->notNull()->comment('شناسه کاربر'),
            'user_table'=> $this->string(127)->notNull()->comment('جدول کاربران'),
        ];
        $this->createTable($this->loginTable, $fields, $this->comment('تاریخچه ورود کاربران به سامانه'));

        $this->createIndex('idx-login-user_id', $this->loginTable, 'user_id');
        $this->createIndex('idx-login-user_table', $this->loginTable, 'user_table');
        $this->createIndex('idx-login-username', $this->loginTable, 'username');
        $this->createIndex('idx-login-date', $this->loginTable, 'date');
    }
    
    private function createEmailsTable(){
        $fields = [
            'id'=> $this->bigPrimaryKey()->unsigned()->comment('شناسه جدول'),
            'responsible_model'=> $this->string(127)->notNull()->comment('مدل/حدول فعال کننده ایمیل'),
            'responsible_record'=> $this->string(127)->notNull()->comment('رکورد مرتبط در جدول'),
            'workflow_transition'=> $this->string(127)->comment('انتقال گردش کار انجام شده'),
            'content'=> $this->text()->notNull()->comment('متن ایمیل'),
            'user_id'=> $this->string(127)->notNull()->comment('شناسه کاربر تغییر دهنده گردش کار'),
            'enqueue_timestamp'=> $this->bigInteger()->notNull()->comment('زمان افزایش به صف ارسال'),
            'recipient_id'=> $this->string(127)->notNull()->comment('شناسه گیرنده'),
            'recipient_email'=> $this->string(127)->notNull()->comment('ایمیل گیرنده'),
            'cc_receivers'=> $this->string(127)->notNull()->comment('ایمیل گیرندگان رونوشت'),
            'attachments'=> $this->string(127)->notNull()->comment('نام فایلهای پیوست'),
        ];
        
        $this->createTable($this->emailsTable, $fields, $this->comment('تاریخچه ارسال ایمیل خودکار گردش کار'));
        
        $this->createIndex('idx_email-user_id', $this->emailsTable, 'user_id');
        $this->createIndex('idx_email-recipient_id', $this->emailsTable, 'recipient_id');
        $this->createIndex('idx_email-workflow_transition', $this->emailsTable, 'workflow_transition');
    }
}
