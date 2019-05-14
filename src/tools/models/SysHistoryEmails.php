<?php


namespace khans\utils\tools\models;

/**
 * This is the model class for table "sys_history_emails".
 *
 * @package KHanS\Utils
 * @version 0.1.0-980219
 * @since   1.0
 */
class SysHistoryEmails extends \khans\utils\models\KHanModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_history_emails';
    }
    //todo: add sending time, result and probably log of sending to recipient and cc receivers
    //todo: how to keep log of sending workflow (someone sets an email to send, another approves, and finally in is sent
    /**
     * Disable all behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [];
    }
}
