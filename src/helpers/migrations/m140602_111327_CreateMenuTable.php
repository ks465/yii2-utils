<?php

use mdm\admin\components\Configs;

/**
 * Class m140602_111327_createMenuTable creates a table for storing menus of the site.
 * A single table is used if there is more than one application in the site.
 *
 * @package KHanS\Utils
 * @version 0.3.2-970804
 * @since   1.0
 */
class m140602_111327_CreateMenuTable extends khans\utils\helpers\migrations\KHanMigration
{
    /**
     * Create a single menu to hold all the menus
     */
    public function safeUp()
    {
        $menuTable = Configs::instance()->menuTable;

        $this->createMenuTable($menuTable);
    }

    /**
     * remove table of menus as stored in the params section of site config
     */
    public function safeDown()
    {
        $this->dropTable(Configs::instance()->menuTable);
    }

    /**
     * Create a table holding menu items
     *
     * @param string $menuTable
     */
    protected function createMenuTable($menuTable): void
    {
        $this->createTable($menuTable, [
            'id'     => $this->primaryKey(),
            'app'    => $this->string(64)->notNull()->defaultValue('_SIMPLE_APP_'),
            'name'   => $this->string(128)->notNull(),
            'parent' => $this->integer(),
            'route'  => $this->string(),
            'order'  => $this->integer(),
            'data'   => $this->binary(),
        ], $this->tableOptions);

        $this->addForeignKey($menuTable . '_parent_fk', $menuTable, 'parent', $menuTable,
            'id', 'SET NULL', 'CASCADE');
    }
}
