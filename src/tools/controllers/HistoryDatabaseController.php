<?php


namespace khans\utils\tools\controllers;

use khans\utils\controllers\KHanWebController;
use khans\utils\tools\models\search\SysHistoryDatabaseSearch;
use Yii;

/**
 * HistoryDatabaseController implements the CRUD actions for SysHistoryDatabase model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971016
 * @since   1.0
 */
class HistoryDatabaseController extends KHanWebController
{
    /**
     * Lists all SysHistoryDatabase models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysHistoryDatabaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//todo: delete all records or old records
}
