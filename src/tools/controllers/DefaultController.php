<?php


namespace khans\utils\tools\controllers;

use yii\web\Controller;

/**
 * Default controller for the `khan` module
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-980208
 * @since   1.0 */
class DefaultController extends Controller
{
    /**
     * Action classes used in this module
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
