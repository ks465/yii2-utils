<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/5/16
 * Time: 12:23 PM
 */


namespace khans\utils\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;



/**
 * Class KHanWebController offers common behavior for web controllers
 *
 * @package khans\utils\controllers
 * @version 0.3.1-980219
 * @since 1.0
 */
class KHanWebController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error'        => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha'      => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'help'         => [
                'class' => '\khans\utils\actions\help\HelpAction',
            ],
            'table-schema' => [
                'class' => '\khans\utils\actions\ListTablesAction',
            ],
            'list-users'   => [
                'class' => '\khans\utils\actions\ListUsersAction',
            ],
        ];
    }
    
    /**
     * Show history of changes in the given record
     *
     * @param integer $id
     *
     * @return array AJAX grid view of changes in the given record
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAudit($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider(['query' => $model->getActionHistory()]);

        return [
            'title'   => "رکورد #" . $model->id . ' جدول Test Workflow Events with EAV',
            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
            '<strong class="text-info pull-right">'. '* These are EAV Fields' . '</strong>',
        ];
    }

    /**
     * Find and filter data for Parent/child pattern
     *
     * @param string $q
     *
     * @return array
     */
    public function actionParentsList($q)
    {
        //todo: extend this method in controllers for Child roles
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['results' => []];

        return $out;
    }
}
