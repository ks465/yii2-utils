<?php

namespace khans\utils\helpers\migrations;

/**
 * Class m190211_093452_CreateEAVTables creates tables required for implementing EAV pattern
 *
 * @package KHanS\Utils
 * @version 0.1.6-971125
 * @since   1.0
 */
class m190211_093452_CreateEAVTables extends KHanMigration
{
    /**
     * @var string table containing attributes of EAV models
     */
protected $attributeTable = 'sys_eav_attributes';
    /**
     * @var string table containing values of EAV attributes
     */
protected $valueTable = 'sys_eav_values';

    /**
     * Remove indexes and tables
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_attributes_values', $this->valueTable);

        $this->dropTable($this->valueTable);
        $this->dropTable($this->attributeTable);
    }
    /**
     * Add tables and indexes
     */
    public function safeUp()
    {
        $this->createAttributeTable();
        $this->createValueTable();
    }

    /**
     * Created table for saving defined attributes
     */
    private function createAttributeTable()
    {
        $fields = [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'entity_table' => $this->string(63)->notNull()->comment('Entity Table'),
            'attr_name'=> $this->string(63)->notNull()->comment('Attribute Name'),
            'attr_label' => $this->string(127)->notNull()->comment('Attribute Label'),
            'attr_type' => $this->enum(['boolean','string', 'number'])->notNull()->comment('Data Type'),
            'attr_length' => $this->string(31)->comment('Data Length'),
            'attr_scenario' => $this->string(31)->notNull()->defaultValue('public')->comment('Scenario When the Attribute is Active'),
        ];
        $this->createTableWithLoggers($this->attributeTable, $fields, $this->comment('EAV Attributes Table'));

        $this->createIndex('idx_entity_tables', $this->attributeTable, 'entity_table');
        $this->createIndex('uq_entity_tables_attributes', $this->attributeTable, ['entity_table', 'attr_name'], true);
    }

    /**
     * Add tables for saving defined values
     */
    private function createValueTable()
    {
        $fields = [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'attribute_id'=> $this->integer(11)->unsigned()->notNull()->comment('Attribute ID'),
            'record_id' => $this->integer()->notNull()->comment('Entity Table Record ID'),
            'value' => $this->string(1023)->notNull()->comment('Data Value'),
        ];
        $this->createTableWithLoggers($this->valueTable, $fields, $this->comment('EAV Values Table'));

        $this->addForeignKey('fk_attributes_values', $this->valueTable, 'attribute_id', $this->attributeTable, 'id',
            'CASCADE', 'CASCADE');

        $this->createIndex('uq_entity_tables_values', $this->valueTable, ['attribute_id', 'record_id'], true);
    }
}
