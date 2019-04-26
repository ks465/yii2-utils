<?php


namespace khans\utils\demos\data;


use Yii;

class SysHistoryUsers extends \khans\utils\tools\models\SysHistoryUsers
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