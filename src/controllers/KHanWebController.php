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

/**
 * Class KHanConsoleController offers common behavior for web controllers
 *
 * @package khans\utils\controllers
 * @version 0.2.0-980123
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
     * Find and filter data for Parent/child pattern
     *
     * @param string $q
     *
     * @return array
     */
    public function actionParentsList($q = '')
    {
        //todo: extend this method in controllers for Child roles
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['results' => []];

        return $out;
    }
}
