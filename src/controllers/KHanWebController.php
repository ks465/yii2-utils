<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/5/16
 * Time: 12:23 PM
 */


namespace khans\utils\controllers;


use khans\utils\components\rest\Security;
use khans\utils\Settings;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\rest\Action;
use yii\rest\IndexAction;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class KHanConsoleController offers common behavior for web controllers
 *
 * @package khans\utils\controllers
 * @version 0.1.0-970915
 * @since 1.0
 */
class KHanWebController extends Controller
{

}
