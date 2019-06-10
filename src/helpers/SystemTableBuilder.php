<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 17/01/19
 * Time: 19:51
 */


namespace khans\utils\helpers;

use app\models\system\SysDbFields;
use app\models\system\SysDbTables;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\db\Query;

/**
 * Class SystemTableBuilder manages construction and destruction of system tables based on data stored in system tables.
 * See [[m190103_083414_InitSystemTables]]
 *
 * @package khans\utils
 * @version 0.1.0-971027
 * @since   1.0
 */
class SystemTableBuilder extends BaseObject
{
    /**
     * @var array list of errors during the process
     */
    protected $errorList = [];
    /**
     * @var array list of models which are needed to be updated
     */
    protected $updateModels = [];
    /**
     * @var array list of models which are needed to be removed
     */
    protected $removeModels = [];

//<editor-fold Desc="Getters">

    /**
     * @return array list of models which are needed to be updated
     */
    public function getUpdateModels(): array
    {
        $this->updateModels = array_unique($this->updateModels);

        return $this->updateModels;
    }

    /**
     * @return array list of models which are needed to be removed
     */
    public function getRemoveModels(): array
    {
        $this->removeModels = array_unique($this->removeModels);

        return $this->removeModels;
    }

    /**
     * @return bool if the process has encountered any errors
     */
    public function hasError(): bool
    {
        return count($this->errorList) > 0;
    }

    /**
     * Clear the error list of the class
     */
    public function clearErrors()
    {
        $this->errorList = [];
    }

    /**
     * @return array
     */
    public function getErrorList(): array
    {
        return $this->errorList;
    }
//</editor-fold Desc="Getters">

//<editor-fold Desc="Check Tables & Fields">
    /**
     * Check structures for all the system tables.
     */
    public function checkAllTables(): void
    {
        /* @var SysDbTables $table */
        foreach (SysDbTables::find()->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC])->all() as $table) {
            $this->checkOneTable($table);
        }
    }

    /**
     * Start to check one table of the system tables.
     *
     * @param SysDbTables $table table object
     *
     * @return bool result of action
     */
    public function checkOneTable(SysDbTables $table): bool
    {
        $activeTables = \Yii::$app->db->schema->getTableNames();

        if (in_array($table->maria_table, $activeTables) and $table->is_applied) {
            $this->checkFields($table);
        } else {
            if ($this->createOneTable($table)) {
                $table->is_applied = true;
                $table->time_edited = time();
                $this->updateModels[] = $table->maria_table;
            }
        }

        $this->checkPrimaryKey($table);

        $table->version += 1;
        $table->save();

        return true;
    }

    /**
     * Check each field in the given table and update it with regard to the definitions.
     *
     * @param SysDbTables $table the table to check its fields
     *
     * @return bool result of updating fields in a table
     */
    private function checkFields(SysDbTables $table): bool
    {
        $activeFields = \Yii::$app->db->getTableSchema($table->maria_table);
        if (empty($activeFields)) {
            $this->errorList[] = [__LINE__ => $table->maria_table . ' has no fields in database.'];

            return false;
        }

        $query = SysDbFields::find()->where(['table_id' => $table->id])->orderBy([
            'order' => SORT_ASC, 'id' => SORT_ASC,
        ]);

        /* @var SysDbFields $field */
        foreach ($query->all() as $field) {
            if (empty($field->maria_field) or empty($field->maria_format) or empty($field->label) or $field->order === 0) {
                $this->errorList[] = [__LINE__ => $field->maria_field . ' Data is not complete.'];
                continue;
            }
            $this->checkForeignKeys($field);
            if (array_key_exists($field->maria_field, $activeFields->columns) and $field->is_applied) {
                continue;
            }

            if (!array_key_exists($field->maria_field, $activeFields->columns)) {
                $sql = \Yii::$app->db->createCommand()->addColumn($table->maria_table, $field->maria_field,
                    strtoupper($field->maria_format) . ' COMMENT "' . $field->label . '"');
            } elseif (!$field->is_applied) {
                $sql = \Yii::$app->db->createCommand()->alterColumn($table->maria_table, $field->maria_field,
                    strtoupper($field->maria_format) . ' COMMENT "' . $field->label . '"');
//            } else {
//                throw new InvalidConfigException('MariaDB Field is Applied already.');
            }

            try {
                $sql->execute();
                $field->is_applied = 1;
                $field->time_edited = time();
                $table->version += 1;
                if ($field->validate()) {
                    $field->save();
                } else {
                    vdd($field->errors);
                }
                $this->updateModels[] = $table->maria_table;

                return true;
            } catch (Exception $e) {
                $this->errorList[] = [__LINE__ => $e->getMessage()];

                return false;
            }
        }

        return false;
    }

    /**
     * Create a new table based on the definitions in the tables
     *
     * @param SysDbTables $table the new table to create
     *
     * @return bool result of executing the sql commands
     */
    private function createOneTable(SysDbTables $table): bool
    {
        $fields = $this->createFieldConfig($table->id);
        if (empty($fields)) {
            $this->errorList[] = [__LINE__ => $table->maria_table . ' has no defined field.'];

            return false;
        }
        $sql = \Yii::$app->db->createCommand()->createTable($table->maria_table, $fields,
            ' ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT "' . $table->comment . '"');
        try {
            $sql->execute();
        } catch (Exception $e) {
            $this->errorList[] = [__LINE__ => $e->getMessage()];
        }

        $sql = \Yii::$app->db->createCommand()
            ->addPrimaryKey('pk_' . $table->maria_table, $table->maria_table, $table->maria_pk);
        try {
            $sql->execute();

            return true;
        } catch (Exception $e) {
            $this->errorList[] = [__LINE__ => $e->getMessage()];

            return false;
        }

    }
//</editor-fold Desc="Check Tables & Fields">

//<editor-fold Desc="Drop Tables">

    /**
     * Check if the primary key of the table is set and is updated.
     *
     * @param SysDbTables $table the table to check
     *
     * @return bool result of checking and/or setting primary key
     */
    private function checkPrimaryKey(SysDbTables $table): bool
    {
        try {
            $currentPK = \Yii::$app->db->createCommand('SHOW INDEXES FROM :table WHERE Key_name = "PRIMARY";',
                [':table' => $table->maria_table])
                ->queryAll();
            $currentPK = array_column($currentPK, 'Column_name');
        } catch (\yii\db\Exception $e) {
            return false;
        }
        $setPK = explode(',', $table->maria_pk);

        if ($currentPK == $setPK) {
            return true;
        }
        $sql = \Yii::$app->db->createCommand()
            ->addPrimaryKey('pk_' . $table->maria_table, $table->maria_table, $table->maria_pk);
        try {
            $sql->execute();

            return true;
        } catch (Exception $e) {
            $this->errorList[] = [__LINE__ => $e->getMessage()];

            return false;
        }
    }

    /**
     * Check if the foreign keys of the feild are set and updated.
     *
     * @param SysDbFields $field the field to check foreign constraints
     *
     * @return bool result of checking or setting the foreign key
     */
    private function checkForeignKeys(SysDbFields $field): bool
    {
        if (empty($field->reference_table) or empty($field->reference_field)) {
            return true;
        }

        $query = new Query();
        $query
            ->select([
                'TABLE_NAME', 'COLUMN_NAME', 'CONSTRAINT_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME',
            ])
            ->from('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')
            ->andWhere(['CONSTRAINT_NAME' => 'fk_' . $field->table->maria_table . '_' . $field->referenceTable->maria_table])
            ->andWhere(['COLUMN_NAME' => $field->maria_field])
            ->andWhere(['TABLE_NAME' => $field->table->maria_table])
            ->andWhere(['REFERENCED_TABLE_NAME' => $field->referenceTable->maria_table])
            ->andWhere(['REFERENCED_COLUMN_NAME' => $field->referenceField->maria_field]);
        if ($query->exists()) {
            return true;
        }

        $sql = \Yii::$app->db->createCommand()->addForeignKey(
            'fk_' . $field->table->maria_table . '_' . $field->referenceTable->maria_table,
            $field->table->maria_table,
            $field->maria_field,
            $field->referenceTable->maria_table,
            $field->referenceField->maria_field
        );

        try {
            $sql->execute();
            $this->updateModels[] = $field->table->maria_table;
            $this->updateModels[] = $field->referenceTable->maria_table;

            return true;
        } catch (Exception $e) {
            $this->errorList[] = [__LINE__ => $e->getMessage()];

            return false;
        }
    }

    /**
     * Create list of configuration for fields of the table
     *
     * @param integer $tableID
     *
     * @return array list of field definitions
     */
    private function createFieldConfig(int $tableID): array
    {
        $tableFields = SysDbFields::find()
            ->select(['maria_field', 'maria_format', 'label', 'order'])
            ->where(['table_id' => $tableID])
            ->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC]);
        $fields = [];

        /* @var $field SysDbFields */
        foreach ($tableFields->all() as $field) {
            if (empty($field->maria_field) or empty($field->maria_format) or empty($field->label) or $field->order === 0) {
                continue;
            }
            $fields[$field->maria_field] = strtoupper($field->maria_format) . ' COMMENT "' . $field->label . '"';
            $field->is_applied = true;
            $field->time_edited = time();
            $field->save();
        }

        return $fields;
    }
//</editor-fold Desc="Drop Tables">

//<editor-fold Desc="Create">

    /**
     * Check only one system table for its structure.
     *
     * @param string $tableName name of table in MariaDB
     *
     * @return bool result of process
     */
    public function checkOneTableByName(string $tableName): bool
    {
        return $this->checkOneTable(SysDbTables::find()->where(['maria_table' => $tableName])->one());
    }

    /**
     * Drop all the system tables.
     */
    public function dropAllTables(): void
    {
        /* @var SysDbTables $table */
        foreach (SysDbTables::find()->orderBy(['order' => SORT_DESC, 'id' => SORT_DESC])->all() as $table) {
            $this->dropOneTable($table);
        }
    }
//</editor-fold Desc="Create">

//<editor-fold Desc="Check Keys">

    /**
     * Drop one system table from database.
     *
     * @param SysDbTables $table
     *
     * @return bool
     */
    public function dropOneTable(SysDbTables $table): bool
    {
        $query = new Query();
        $query
            ->select(['TABLE_NAME', 'CONSTRAINT_NAME', 'REFERENCED_TABLE_NAME'])
            ->from('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')
            ->andWhere(['TABLE_NAME' => $table->maria_table])
            ->andWhere(['!=', 'CONSTRAINT_NAME', 'PRIMARY']);

        if ($query->exists()) {
            foreach ($query->all() as $item) {
                $sql = \Yii::$app->db->createCommand()->dropForeignKey($item['CONSTRAINT_NAME'], $item['TABLE_NAME']);
                try {
                    $sql->execute();
                } catch (\yii\db\Exception $e) {
                    $this->errorList[] = [__LINE__ => $e->getMessage()];
                }
            }
        }
        $sql = \Yii::$app->db->createCommand()->dropTable($table->maria_table);
        try {
            $sql->execute();

            $table->is_applied = 0;
            $table->save();
            $this->removeModels[] = $table->maria_table;

            SysDbFields::updateAll(['is_applied' => 0], ['table_id' => $table->id]);

            return true;
        } catch (\yii\db\Exception $e) {
            $this->errorList[] = [__LINE__ => $e->getMessage()];

            return false;
        }
    }

    /**
     * Drop only one system table.
     *
     * @param string $tableName name of table in MariaDB
     *
     * @return bool result of process
     */
    public function dropOneTableByName(string $tableName): bool
    {
        return $this->dropOneTable(SysDbTables::find()->where(['maria_table' => $tableName])->one());
    }
//</editor-fold Desc="Check Keys">
}
