<?php

namespace khans\utils\helpers\migrations;



use khans\utils\tools\models\SysHistoryDatabase;
use khans\utils\tools\models\SysHistoryUsers;

/**
 * Class m190128_152310_CreateHistoryTables creates tables containing history of login and changes in records
 *
 * @package KHanS\Utils
 * @version 0.1.4-971111
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
     * Set name of tables to values set in the models
     */
    public function init()
    {
        $this->loginTable   = SysHistoryUsers::tableName();
        $this->historyTable   = SysHistoryDatabase::tableName();
        parent::init();
    }

    /**
     * Remove indexes and two tables
     */
    public function safeDown()
    {
        $this->dropTable($this->loginTable);
        $this->dropTable($this->historyTable);
    }

    /**
     * Define the two tables and indexes
     */
    public function safeUp()
    {
        $this->createHistoryTable();
        $this->createLogsTable();
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
}
