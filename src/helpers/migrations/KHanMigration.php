<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 26/10/18
 * Time: 15:05
 */


namespace khans\utils\helpers\migrations;

use khans\utils\components\FileHelper;
use KHanS\Utils\models\KHanIdentity;
use khans\utils\models\KHanModel;
use yii\base\NotSupportedException;
use yii\db\Migration;

/**
 * Class KHanMigration holds extra abilities for migrating required tables.
 * Most of these capabilities are targeted toward MariaDB only.
 *
 * @package KHanS\Utils
 * @version 0.5.2-971122
 * @since   1.0
 */
class KHanMigration extends Migration
{
    /**
     * @var string|null Extra options for creating a table.
     */
    protected $tableOptions = null;

    /**
     * Setup collation and InnoDB engine if the database driver is MariaDB or MySQL
     */
    public function init()
    {
        parent::init();

        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_persian_ci ENGINE=InnoDB';
        }
    }

    /**
     * Create a field of type ENUM
     *
     * @param array list of ENUMs
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     * @throws NotSupportedException
     */
    protected function enum(array $enum)
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('ENUM', '"' . implode('", "', $enum) . '"');
    }

    /**
     * Create an auto increment primary key of type SMALLINT
     *
     * @param integer $length precision definition
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     */
    protected function smallPrimaryKey($length = null)
    {
        return $this->smallInteger($length)->unique()->notNull()->append(' NOT NULL AUTO_INCREMENT');
    }

    /**
     * Creates a BIT column.
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     */
    protected function bit()
    {
        try {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder('bit');
        } catch (NotSupportedException $e) {
            return $this->boolean();
        }
    }

    /**
     * Creates a longtext column.
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     */
    protected function longText()
    {
        try {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext');
        } catch (NotSupportedException $e) {
            return $this->text();
        }
    }

    /**
     * Creates a longblob column.
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     */
    protected function longBlob()
    {
        try {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder('longblob');
        } catch (NotSupportedException $e) {
            return $this->binary();
        }
    }

    /**
     * Creates a char column and set the collation to latin1_general_ci.
     *
     * @param integer $length column size or precision definition. This parameter will be ignored if not supported by
     * the DBMS.
     *
     * @return \yii\db\ColumnSchemaBuilder|\yii\db\mysql\ColumnSchemaBuilder the column instance which can be further
     * customized.
     */
    protected function latinChar($length = null)
    {
        return $this->char($length)->append(' COLLATE latin1_general_ci');
    }

    /**
     * Add five standard fields to table definition, and creates the table.
     *
     * @param string $table name of the table in database.
     * @param array  $columns list of columns with corresponding definitions.
     * @param string $options custom options for table in order to bypass [[tableOptions]]
     *
     * @return void
     */
    protected function createTableWithLoggers($table, $columns, $options = null)
    {
        if (is_null($options)) {
            $options = $this->tableOptions;
        }
        $this->createTable($table, $columns + $this->addLoggersFields(), $options);
    }

    /**
     * Add five standard fields and definitions to user-defined list of fields. These fields are:
     * `status`
     * `created_by`
     * `updated_by`
     * `created_at`
     * `updated_at`
     *
     * @return array
     */
    protected function addLoggersFields()
    {
        $item = [
            'status'     => $this->tinyInteger(4)->unsigned()->null()->comment('وضعیت رکورد'),
            'created_by' => $this->integer(11)->unsigned()->null()->comment('سازنده'),
            'updated_by' => $this->integer(11)->unsigned()->null()->comment('ویرایشگر'),
            'created_at' => $this->integer(11)->unsigned()->null()->comment('زمان افزودن'),
            'updated_at' => $this->integer(11)->unsigned()->null()->comment('زمان آخرین ویرایش'),
        ];

        return $item;
    }

    /**
     * Add comment to the table options.
     *
     * @param string $comment Comment for the table.
     *
     * @return string $tableOptions
     * @see KHanMigration::tableOptions
     */
    protected function comment($comment)
    {
        if (!$this->isSQLite()) {
            $this->tableOptions .= " COMMENT='" . $comment . "'";
        }

        return $this->tableOptions;
    }

    /**
     * Check if the database component is Oracle
     *
     * @return bool
     */
    protected function isSQLite()
    {
        return $this->db->driverName === 'sqlite';
    }

    /**
     * Check if the database component is MS SQL
     *
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * Check if the database component is Oracle
     *
     * @return bool
     */
    protected function isOracle()
    {
        return $this->db->driverName === 'oci';
    }

    /**
     * Read data from StdIn and create records in created models
     *
     * @param string       $prompt text to show in the command prompt to get user's input
     * @param KHanIdentity $model the model to set attribute to
     * @param string       $field attribute name
     * @param string       $default default value for the question
     *
     * @return string result of questioning user for a value
     */
    protected function readStdIn($prompt, $model, $field, $default = '')
    {
        while (!isset($input) || !$model->validate([$field])) {
            if ($model->hasErrors($field)) {
                $_prompt = $model->getFirstError($field);
            } else {
                $_prompt = $prompt;
            }
            echo $_prompt . (($default) ? " [$default]" : '') . ': ';
            $input = (trim(fgets(STDIN)));
            if (empty($input) && !empty($default)) {
                $input = $default;
            }
            $model->$field = $input;
        }

        return $input;
    }

    /**
     * Load data from initiating CSV files into the database
     *
     * @param string $tableName name of table to insert data into
     * @param string $csvFile path to the CSV file
     * @param bool   $addLoggers add 5-fields loggers to the data
     */
    protected function load($tableName, $csvFile, $addLoggers = true)
    {
        if (is_null($csvFile)) {
            $csvFile = $tableName;
        }

        foreach (FileHelper::loadCSV($csvFile) as $row) {
            if ($addLoggers) {
                $row = $this->addLoggers($row);
            }
            $this->insert($tableName, $row);
        }
    }

    /**
     * Add five standard fields in tables to the default data
     *
     * @param array $item single row data
     *
     * @return array row data including the logger fields
     */
    protected function addLoggers($item)
    {
        $item['status'] = KHanModel::STATUS_ACTIVE;
        $item['created_by'] = 0;
        $item['updated_by'] = 0;
        $item['created_at'] = time();
        $item['updated_at'] = time();

        return $item;
    }
}
