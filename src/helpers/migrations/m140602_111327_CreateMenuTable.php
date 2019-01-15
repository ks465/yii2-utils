<?php


namespace khans\utils\helpers\migrations;

use mdm\admin\components\Configs;

/**
 * Class m140602_111327_createMenuTable creates a table for storing menus of the site.
 * A single table is used if there is more than one application in the site.
 *
 * @package KHanS\Utils
 * @version 0.4.1-971013
 * @since   1.0
 */
class m140602_111327_CreateMenuTable extends KHanMigration
{
    /**
     * Create a single menu to hold all the menus
     */
    public function safeUp()
    {
        $menuTable = Configs::instance()->menuTable;

        $this->createMenuTable($menuTable, 'Application Menu data');
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
     * @param string $tableComment comment of the table
     */
    protected function createMenuTable($menuTable, $tableComment): void
    {
        $this->createTable($menuTable, [
            'id'     => $this->primaryKey(),
            'app'    => $this->string(64)->notNull()->defaultValue('_SIMPLE_APP_')->comment('برنامه مرتبط'),
            'name'   => $this->string(128)->notNull()->comment('عنوان'),
            'parent' => $this->integer()->comment('شاخه بالایی'),
            'route'  => $this->string()->comment('مسیر'),
            'order'  => $this->integer()->comment('ترتیب'),
            'data'   => $this->binary()->comment('داده'),
        ], $this->comment($tableComment));

        $this->addForeignKey($menuTable . '_parent_fk', $menuTable, 'parent', $menuTable,
            'id', 'SET NULL', 'CASCADE');
    }
}
