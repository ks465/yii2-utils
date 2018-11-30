<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Initializes RBAC tables. Name of tables are defined in the authManager component of the site.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 *
 * @package KHanS\Utils
 * @version 0.3.2-970804
 * @since   1.0
 */
class m140506_102106_InitRbacTables extends khans\utils\helpers\migrations\KHanMigration
{

    /**
     * @throws \yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = \Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    /**
     * drop RBAC tables
     *
     * @return bool|void
     * @throws InvalidConfigException
     */
    public function safeDown()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }

    /**
     * Create RBAC tables
     *
     * @return bool|void
     * @throws InvalidConfigException
     */
    public function safeUp()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $this->createRuleTable($authManager);
        $this->createItemTable($authManager);
        $this->createItemChildTable($authManager);
        $this->createAssignmentTable($authManager);

        $this->addAdmin($authManager);
    }

    /**
     * Create table holding business rules
     *
     * @param DbManager $authManager
     */
    protected function createRuleTable($authManager): void
    {
        $this->createTable($authManager->ruleTable, [
            'name'       => $this->string(64)->notNull(),
            'data'       => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $this->tableOptions);
    }

    /**
     * Create table holding RBAC items
     *
     * @param DbManager $authManager
     */
    protected function createItemTable($authManager): void
    {
        $this->createTable($authManager->itemTable, [
            'name'        => $this->string(64)->notNull(),
            'type'        => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name'   => $this->string(64),
            'data'        => $this->binary(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

        $this->addForeignKey($authManager->itemTable . '_rule_name_fk', $authManager->itemTable, 'rule_name', $authManager->ruleTable,
            'name', 'SET NULL', 'CASCADE');
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');
    }

    /**
     * Create table holding RBAC item children
     *
     * @param DbManager $authManager
     */
    protected function createItemChildTable($authManager): void
    {
        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child'  => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
        ], $this->tableOptions);

        $this->addForeignKey($authManager->itemChildTable . '_parent_fk', $authManager->itemChildTable, 'parent', $authManager->itemTable,
            'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey($authManager->itemChildTable . '_child_fk', $authManager->itemChildTable, 'child', $authManager->itemTable,
            'name', 'CASCADE', 'CASCADE');
    }

    /**
     * Create table hoding assignments
     *
     * @param DbManager $authManager
     */
    protected function createAssignmentTable($authManager): void
    {
        $this->createTable($authManager->assignmentTable, [
            'item_name'  => $this->string(64)->notNull(),
            'user_id'    => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
        ], $this->tableOptions);

        $this->addForeignKey($authManager->assignmentTable . '_item_name_fk', $authManager->assignmentTable, 'item_name',
            $authManager->itemTable, 'name', 'CASCADE', 'CASCADE');

        $this->createIndex($authManager->assignmentTable . '_user_id_idx', $authManager->assignmentTable, 'user_id');
    }

    /**
     * Add records to the created table allowing user with id = 1 all accesses as admin
     *
     * @param DbManager $authManager
     */
    protected function addAdmin($authManager)
    {
        $this->insert($authManager->itemTable, [
            'name' => '/*',
            'type' => '2',
        ]);
        $this->insert($authManager->itemTable, [
            'name' => 'admin',
            'type' => '1',
        ]);
        $this->insert($authManager->itemChildTable, [
            'parent' => 'admin',
            'child'  => '/*',
        ]);
        $this->insert($authManager->assignmentTable, [
            'item_name' => 'admin',
            'user_id'   => '1',
        ]);
    }
}
