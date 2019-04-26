<?php /** @noinspection PhpComposerExtensionStubsInspection */


/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/9/16
 * Time: 5:33 PM
 */


namespace khans\utils\components\rest_v1;

use khans\utils\components\StringHelper;
use khans\utils\components\ViewHelper;
use khans\utils\models\KHanModel;
use khans\utils\Settings;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Class Client is the main actor for requesting REST data.
 *
 * @package khans\utils\components\rest_v1
 * @version 2.0.0-950419
 * @since 1.0
 */
abstract class Client extends BaseObject
{
    /**
     * @var string authentication token
     *             Important! the value should be exactly the same as Rest server RESTAuth::$key
     */
    private static $hash = 'TFhSjkVAwv-mPSwoh3s2KMIWqz4QUZQq_5uXjB5YLg5rouy68i_ESDbU0Mm9NjpM';
    /**
     * @var string encryption key
     *             Important! the value should be exactly the same as Rest server RESTSecurity::$key
     */
    private static $key = 'bWLXDYItgIgqJA9EQYxsNknCIPCwlTd0gYxEu1zKAKU=';

    public function init()
    {
        self::$key = base64_decode(self::$key);
    }

    /**
     * Create an OTP for retrieving data from REST Server
     * Important! the [[self::$hash]] value should be exactly the same as Rest server RESTAuth::$hash
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function lock()
    {
        $time = microtime(true);
        $rand = rand(1e2, 1e7);
        $authKey = \Yii::$app->security->hashData($time, self::$hash) . '_' .
            \Yii::$app->security->hashData($rand, self::$hash);
        $authKey = strrev($authKey);

        return $authKey;
    }

    /**
     * decrypt array or string
     * Important! the [[self::$key]] value should be exactly the same as Rest server RESTSecurity::$key
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
            return \Yii::$app->security->decryptByKey(base64_decode($sData), self::$key);
        }
    }

    /**
     * read data from the REST server
     *
     * @param string  $model requested data model -- equivalent to controller id
     * @param integer $pk key to find the requested record on the REST server
     *
     * @return array REST server response
     * @throws HttpException
     * @throws NotFoundHttpException if failed to connect and read data from server
     * @throws UserException
     * @throws InvalidConfigException
     */
    public static function read($model, $pk = null)
    {
        if (!is_null($pk)) {
            $pk = '/' . $pk;
        }

        $query = Settings::REST_SERVER_URL . $model . $pk . '?' . Settings::REST_TOKEN_PARAM . '=' . self::lock();

        try {
            $dataList = file_get_contents($query, false);
            $dataList = json_decode($dataList, true);
            $dataList = self::decrypt($dataList);
            $dataList = StringHelper::correctYaKa($dataList);

            return $dataList;
        } catch (\Exception $e) {
            if (stripos($e->getMessage(), 'HTTP/1.1 423 Locked') > 0) {
                throw new HttpException(423, 'سرور در حال به روز رسانی است. پس از مدتی دوباره آزمایش کنید.', 423);
            }
            if (\Yii::$app->user->isSuperAdmin && (YII_ENV_TEST || YII_DEBUG)) {
                vdd($e, $e->getCode(), $e->getMessage());
            }
            throw new NotFoundHttpException('تماس با سرور برقرار نشد.');

        }
    }

    /**
     * Send data to the REST server
     *
     * @param string $action controller-action id which accepts the data
     * @param array  $data data to send
     *
     * @return bool REST server response
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public static function put($action, $data)
    {
        $data = json_encode($data);
        $lenJson = strlen($data);
        $data = trim(gzdeflate($data));
        $lenGzip = strlen($data);
        $data = urlencode($data);
        $query = \Yii::$app->params['rest_server_url'] . $action . '?data=' . $data .
            '&access-token=' . self::lock();
        try {
            $dataList = file_get_contents($query, false);

            $dataList = json_decode($dataList, true);
            $dataList = self::decrypt($dataList);

            return $dataList['lenJson'] == $lenJson && $dataList['lenGzip'] == $lenGzip && $dataList['success'];
        } catch (\Exception $e) {
            if (\Yii::$app->user->isSuperAdmin && (YII_ENV_TEST || YII_DEBUG)) {
                vdd($e->getCode(), $e->getMessage());
            }
            throw new NotFoundHttpException('تماس با سرور برقرار نشد.');
        }
    }

    /**
     * Show errors in reading data in the session flash object
     *
     * @param KHanModel $model active model receiving data
     * @param array     $data REST data
     */
    protected static function flashErrors($model, $data)
    {
        $string = $model->getModelErrors();
        $string .= ViewHelper::implode($data);
        \Yii::$app->session->addFlash('error', $string);
    }
}
