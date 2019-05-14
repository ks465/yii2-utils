<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/5/16
 * Time: 12:23 PM
 */


namespace khans\utils\controllers;


use khans\utils\components\rest_v1\Security;
use khans\utils\Settings;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\rest\Action;
use yii\rest\ActiveController;
use yii\rest\IndexAction;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class KHanRestController offers common behavior for REST controllers base on version 1 of the REST server
 * @see [components/rest_v1](components-rest-v1.md)
 *
 * @package khans\utils\controllers
 * @version 2.0.0-970912
 * @since 1.0
 */
class KHanRestController extends ActiveController
{
    /**
     * Setup required parameters
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    /**
     * Configure components for access control and authentication through query parameters
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
//                    'ips' => [
//                    ],
                ],
            ],
        ];
        $behaviors['authenticator'] = [
            'class'      => QueryParamAuth::className(),
            'tokenParam' => Settings::REST_TOKEN_PARAM,
        ];

        return $behaviors;
    }

    /**
     * Define common generic actions for all the child acting controllers
     */
    public function actions()
    {
        return [
            'index' => [
                'class'               => 'yii\rest\IndexAction',
                'modelClass'          => $this->modelClass,
                'checkAccess'         => [$this, 'checkAccess'],
                'prepareDataProvider' => function(IndexAction $action) {
                    /** @var $mC \yii\db\BaseActiveRecord */
                    $mC = $action->modelClass;

                    return new ActiveDataProvider([
                        'query'      => $mC::find(),
                        'pagination' => false,
                    ]);
                },
            ],
            'view'  => [
                'class'       => 'yii\rest\ViewAction',
                'modelClass'  => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];
    }

    /**
     * Check for updating periods in the server by reading a default file.
     * If the file does not exist, action will proceed.
     *
     * @param Action $action the action to be executed.
     *
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        try {
            $s = file_get_contents(Url::to(Yii::$app->params['server_busy_constructing_data']));
        } catch (\Exception $e) {
            $s = 0;
        }
        if (1 == $s) {
            throw new HttpException(423, 'Updating in progress. You have to wait. Tray again later.');
        }

        return parent::beforeAction($action);
    }

    /**
     * Encrypt the answer of all the actions
     *
     * @param Action $action the action just executed.
     * @param mixed  $result the action return result.
     *
     * @return string the encrypted action result.
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return Security::encrypt($result);
    }
}
