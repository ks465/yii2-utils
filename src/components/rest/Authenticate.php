<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/3/16
 * Time: 12:20 PM
 */


namespace khans\utils\components\rest;


use yii\base\BaseObject;

/**
 * Class Authenticate creates and validates OTPs for REST server.
 * By doing this, I try to reduce vulnerability to physical security.
 *
 * @package khans\utils\components\rest
 * @version 2.0.0-970912
 * @since 1.0
 */
class Authenticate extends BaseObject
{

    private static $key = 'TFhSjkVAwv-mPSwoh3s2KMIWqz4QUZQq_5uXjB5YLg5rouy68i_ESDbU0Mm9NjpM';

    /**
     * Create an OTP for retrieving data from REST Server
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function lock()
    {
        $time = microtime(true);
        $rand = rand(1e2, 1e7);
        $authKey = \Yii::$app->security->hashData($time, self::$key) . '_' .
            \Yii::$app->security->hashData($rand, self::$key);
        $authKey = strrev($authKey);

        return $authKey;
    }

    /**
     * Check if the received OTP is valid
     * And no more than 10 minutes old
     *
     * @param string $authKey
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function unlock($authKey)
    {
        $authKey = strrev($authKey);
        $authKey = explode('_', $authKey);

        $time = \Yii::$app->security->validateData($authKey[0], self::$key);
        if ($time === false || abs($time - time()) > 600) {
            return false;
        }

        return $time && \Yii::$app->security->validateData($authKey[1], self::$key);
    }
}
