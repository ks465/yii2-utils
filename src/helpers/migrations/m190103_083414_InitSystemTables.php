<?php


namespace khans\utils\helpers\migrations;


/**
 * Class m190103_083414_InitSystemTables creates tables containing definitions for building application data tables.
 *
 * @package KHanS\Utils
 * @version 0.2.1-971028
 * @since   1.0
 */
class m190103_083414_InitSystemTables extends KHanMigration
{
    /**
     * @var string table containing list of tables to be created in the application
     */
    protected $tablesTable = 'sys_database_tables';
    /**
     * @var string table containing list of fields of system tables
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
     * @var array list of fields to create a UNIQUE constraint on the list of tables
     */
    protected $uniqueTable = [];
    /**
     * @var array list of fields to create a UNIQUE constraint on the list of fields
     */
    protected $uniqueField = [];

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
        $this->dropForeignKey('fk_tables_fk_fields', $this->fieldsTable);
        $this->dropForeignKey('fk_fields_fk_fields', $this->fieldsTable);

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
        $this->createIndex('uq_tables', $this->tablesTable, $this->uniqueTable, true);
    }

    /**
     * Build a table containing metadata for creating required fields in the system tables
     */
    protected function buildFieldsTable(): void
    {
        $this->createTable($this->fieldsTable, $this->fieldsTableConfig, $this->comment('فهرست ستونهای جدولهای سیستم'));
        $this->createIndex('uq_fields', $this->fieldsTable, $this->uniqueField, true);
        $this->addForeignKey('fk_tables_fields', $this->fieldsTable, 'table_id', $this->tablesTable, 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tables_fk_fields', $this->fieldsTable, 'reference_table', $this->tablesTable, 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_fields_fk_fields', $this->fieldsTable, 'reference_field', $this->fieldsTable, 'id',
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
            'time_added'   => $this->integer(11)->unsigned()->comment('زمان افزودن به جدول'),
            'time_checked' => $this->integer(11)->unsigned()->comment('زمان آخرین کنترل'),
            'time_edited'  => $this->integer(11)->unsigned()->comment('زمان آخرین به روزرسانی'),
            'is_applied'   => $this->boolean()->defaultValue(false)->comment('در ساختمان داده‌ها به کار گرفته شده است؟'),
        ];
        $this->fieldsTableConfig = [
            'id'              => $this->smallPrimaryKey()->unsigned()->comment('شناسه ستون'),
            'table_id'        => $this->smallInteger()->unsigned()->comment('جدول مرتبط'),
            'field_name'      => $this->latinChar(127)->comment('نام ستون'),
            'field_format'    => $this->latinChar(127)->comment('نوع داده'),
            'label'           => $this->string(255)->notNull()->comment('شرح ستون'),
            'reference_table' => $this->smallInteger()->unsigned()->comment('جدول هدف در یک رابطه'),
            'reference_field' => $this->smallInteger()->unsigned()->comment('ستون هدف در یک رابطه'),
            'order'           => $this->smallInteger(2)->unsigned()->comment('ترتیب به روز رسانی دوره‌ای'),
            'version'         => $this->smallInteger(2)->unsigned()->comment('شماره ویرایش'),
            'time_added'      => $this->integer(11)->unsigned()->comment('زمان افزودن به جدول'),
            'time_checked'    => $this->integer(11)->unsigned()->comment('زمان آخرین کنترل'),
            'time_edited'     => $this->integer(11)->unsigned()->comment('زمان آخرین به روزرسانی'),
            'is_applied'      => $this->boolean()->defaultValue(false)->comment('در ساختمان داده‌ها به کار گرفته شده است؟'),
        ];
    }
}
