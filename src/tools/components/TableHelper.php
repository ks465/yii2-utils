<?php


namespace khans\utils\tools\components;


use Yii;
use yii\base\BaseObject;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * Class TableHelper gathers management components for tables in database
 *
 * @package khans\utils\src\tools\components
 * @version 0.1.0-980208
 * @since   1.0
 */
class TableHelper extends BaseObject
{
    /**
     * If title is not given in the config, produce it from comment of the table in database.
     * If comment is not available return Table Name
     *
     * @param string $tableName Name of table to get the comment
     *
     * @return string
     */
    public static function getTableComment($tableName)
    {
        $query = new Query();

        if (Yii::$app->db->driverName === 'mysql') {
            $comment = $query->from('INFORMATION_SCHEMA.TABLES')
                ->select(['table_comment'])
                ->where(['table_name' => $tableName])
                ->scalar();
        } elseif (Yii::$app->db->driverName === 'pgsql') {
            $comment = $query->from('pg_description')
                ->select(['description'])
                ->innerJoin('pg_class', '{{pg_description}}.[[objoid]] = {{pg_class}}.[[relnamespace]]')
                ->where(['relname' => $tableName])
                ->scalar();
        } else {
            $comment = false;
        }

        return $comment ? : Inflector::humanize($tableName, true);
    }
}