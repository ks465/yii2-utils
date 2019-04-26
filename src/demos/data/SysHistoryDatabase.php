<?php


namespace khans\utils\demos\data;


use Yii;

class SysHistoryDatabase extends \khans\utils\tools\models\SysHistoryDatabase
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('test');
    }
}