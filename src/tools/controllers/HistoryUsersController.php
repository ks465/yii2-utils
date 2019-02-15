<?php


namespace khans\utils\tools\controllers;

use khans\utils\controllers\KHanWebController;
use khans\utils\tools\models\search\SysHistoryUsersSearch;
use Yii;

/**
 * HistoryUsersController implements the CRUD actions for SysHistoryUsers model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971016
 * @since   1.0
 */
class HistoryUsersController extends KHanWebController
{
    /**
     * Lists all SysHistoryUsers models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysHistoryUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//todo: delete all records or old records
}
