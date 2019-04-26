<?php

namespace khans\utils\demos\controllers;

use Yii;
use khans\utils\demos\data\PcParents;
use khans\utils\demos\data\PcParentsSearch;
use yii\data\ActiveDataProvider;
use khans\utils\controllers\KHanWebController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PcParentsController implements the CRUD actions for PcParents model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980130
 * @since   1.0
 */
class PcParentsController extends KHanWebController
{
    /**
     * Lists all PcParents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PcParentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcParents model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PcParents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PcParents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PcParents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PcParents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
            'title'   => "رکورد #" . $model->id . ' جدول List of records having children data',
            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
        ];
    }


    /**
     * Finds the PcParents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcParents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcParents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
    }
}
