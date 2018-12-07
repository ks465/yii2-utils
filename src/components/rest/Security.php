<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/20/16
 * Time: 10:51 AM
 */


namespace khans\utils\components\rest;

use yii\base\BaseObject;
use yii\base\InvalidValueException;

require_once __DIR__ . "/is_serialized.php";

/**
 * Class Security handles encryption and decryption of data transferred to the client
 *
 * @package khans\utils\components\rest
 * @version 2.0.0-970912
 * @since 1.0
 */
class Security extends BaseObject
{
    /**
     * @var string encryption key for the REST serrver
     *             Important! the value should be exactly the same as Rest server RESTSecurity::$key
     */
    private static $key = 'bWLXDYItgIgqJA9EQYxsNknCIPCwlTd0gYxEu1zKAKU=';

    /**
     * Retrieve real key first
     */
    public function init()
    {
        self::$key = base64_decode(self::$key);
    }

    /**
     * Encrypt return value
     *
     * @param string $sData
     *
     * @return bool|string
     */
    public static function encrypt($sData)
    {
        if (is_object($sData)) {
            $sData = serialize($sData);
        }
        if (is_array($sData)) {
            foreach ($sData as &$data) {
                $data = self::encrypt($data);
            }

            return $sData;
        } else {
            return base64_encode(\Yii::$app->security->encryptByKey($sData, self::$key));
        }
    }

    /**
     * Decrypt array or string
     *
     * @param mixed $sData
     *
     * @return mixed
     */
    public static function decrypt($sData)
    {
        if (is_object($sData)) {
            throw new InvalidValueException('Decrypting objects is not supported.');
        }
        if (is_array($sData)) {
            foreach ($sData as &$data) {
                $data = self::decrypt($data);
            }

            return $sData;
        } else {
            $sData = \Yii::$app->security->decryptByKey(base64_decode($sData), self::$key);
            if (strlen($sData) === 0) {
                return $sData;
            }
            if (is_serialized($sData, $tmp)) {
                return $tmp;
            } else {
                return $sData;
            }
        }
    }
}
