<?php


namespace khans\utils\actions;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\db\Schema;
use yii\web\Response;

/**
 * Class ListTablesAction searches the current database connection schema for a table
 *
 * @package khans\utils\controllers
 * @version 0.1.0-980215
 * @since 1.0
 */
class ListTablesAction extends Action
{
    /**
     * @param string $q filtering value
     *
     * @param string $db database connection id
     *
     * @return array
     */
    public function run($q, $db = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];

        /* @var Schema $connection */
        if (is_null($db)) {
            try {
                $connection = \Yii::$app->getDb()->getSchema();
            } catch (NotSupportedException $e) {
            }
        } else {
            try {
                $connection = \Yii::$app->get($db)->getSchema();
            } catch (InvalidConfigException $e) {
            }
        }

        foreach ($connection->tableNames as $tableName) {
            if (strpos($tableName, $q) !== false) {
                $out['results'][] = ['id' => $tableName, 'text' => $tableName];
            }
        }

        return $out;
    }
}