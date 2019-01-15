<?php


namespace khans\utils\helpers\migrations;


/**
 * Class m190103_083414_InitSystemTables creates tables containing definitions for building application data tables.
 *
 * @package KHanS\Utils
 * @version 0.1.5-971013
 * @since   1.0
 */
class m190103_083414_InitSystemTables extends KHanMigration
{
    /**
     * @var string list of tables to be created
     */
    protected $tablesTable = 'sys_database_tables';
    /**
     * @var string list of fields in the created tables
     */
    protected $fieldsTable = 'sys_database_fields';
    /**
     * @var array definitions for the table of tables list
     */
    protected $tablesTableConfig = [];
    /**
     * @var array definitions for table of fields list
     */
    protected $fieldsTableConfig = [];
    /**
     * @var string full path to CSV file containing initialization data for system tables
     */
    protected $tablesCSV = '';
    /**
     * @var string full path to CSV file containing initialization data for system fields
     */
    protected $fieldsCSV = '';

    /**
     * Define required columns
     */
    public function init()
    {
        $this->setupColumnsDefinitions();
        parent::init();
    }

    /**
     * Drop Tables only
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk_tables_fields', $this->fieldsTable);
        $this->dropTable($this->fieldsTable);
        $this->dropTable($this->tablesTable);
    }

    /**
     * Create tables only
     */
    public function safeUp(): void
    {
        $this->buildTablesTable();
        $this->buildFieldsTable();

        if (!empty($this->tablesCSV)) {
            $this->load($this->tablesTable, $this->tablesCSV, false);
        }
        if (!empty($this->fieldsCSV)) {
            $this->load($this->fieldsTable, $this->fieldsCSV, false);
        }
    }

    /**
     * Build a table containing metadata for creating required system tables
     */
    protected function buildTablesTable(): void
    {
        $this->createTable($this->tablesTable, $this->tablesTableConfig, $this->comment('فهرست جدولهای سیستم'));
    }

    /**
     * Build a table containing metadata for creating required fields in the system tables
     */
    protected function buildFieldsTable(): void
    {
        $this->createTable($this->fieldsTable, $this->fieldsTableConfig, $this->comment('فهرست ستونهای جدولهای سیستم'));
        $this->addForeignKey('fk_tables_fields', $this->fieldsTable, 'table_id', $this->tablesTable, 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * Prepare column definition for the given tables.
     * Child classes usually need to override this method only.
     */
    protected function setupColumnsDefinitions(): void
    {
        $this->tablesTableConfig = [
            'id'           => $this->smallPrimaryKey()->unsigned()->comment('شناسه جدول'),
            'table_name'   => $this->latinChar(127)->notNull()->comment('نام جدول'),
            'table_pk'     => $this->latinChar(127)->notNull()->comment('ستونهای کلید اصلی'),
            'comment'      => $this->string(255)->notNull()->comment('شرح جدول'),
            'order'        => $this->smallInteger(2)->unsigned()->comment('ترتیب به روز رسانی دوره‌ای'),
            'version'      => $this->smallInteger(2)->unsigned()->comment('شماره ویرایش'),
            'time_added'   => $this->integer(11)->unsigned()->comment('زمان افزودن به سامانه'),
            'time_checked' => $this->integer(11)->unsigned()->comment('زمان آخرین کنترل'),
            'time_edited'  => $this->integer(11)->unsigned()->comment('زمان آخرین به روزرسانی'),
        ];
        $this->fieldsTableConfig = [
            'id'           => $this->smallPrimaryKey()->unsigned()->comment('شناسه ستون'),
            'table_id'     => $this->smallInteger()->unsigned()->comment('جدول مرتبط'),
            'field_name'   => $this->latinChar(127)->notNull()->comment('نام ستون'),
            'field_format' => $this->latinChar(127)->comment('نوع داده'),
            'label'        => $this->string(255)->notNull()->comment('شرح ستون'),
            'order'        => $this->smallInteger(2)->unsigned()->comment('ترتیب به روز رسانی دوره‌ای'),
            'version'      => $this->smallInteger(2)->unsigned()->comment('شماره ویرایش'),
            'time_added'   => $this->integer(11)->unsigned()->comment('زمان افزودن به سامانه'),
            'time_checked' => $this->integer(11)->unsigned()->comment('زمان آخرین کنترل'),
            'time_edited'  => $this->integer(11)->unsigned()->comment('زمان آخرین به روزرسانی'),
        ];
    }
}
