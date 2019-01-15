<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/5/16
 * Time: 12:23 PM
 */


namespace khans\utils\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class KHanConsoleController offers common behavior for web controllers
 *
 * @package khans\utils\controllers
 * @version 0.1.1-971013
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}
