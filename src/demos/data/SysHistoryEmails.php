<?php


namespace khans\utils\demos\data;

/**
 * This is the model class for table "sys_history_emails".
 *
 * @package KHanS\Utils
 * @version 0.1.0-980219
 * @since   1.0
 */
class SysHistoryEmails extends \khans\utils\tools\models\SysHistoryEmails
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return \Yii::$app->get('test');
    }
}