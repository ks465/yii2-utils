<?php


namespace khans\utils\demos\controllers;

use khans\utils\demos\data\SysEavAttributes;
use khans\utils\demos\data\SysEavAttributesSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * EavAttributesController implements the CRUD actions for SysEavAttributes model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980130
 * @since   1.0
 */
class EavAttributesController extends KHanWebController
{
    /**
     * Lists all SysEavAttributes models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysEavAttributesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysEavAttributes model.
     *
     * @param integer $id
     *
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
     * Creates a new SysEavAttributes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysEavAttributes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SysEavAttributes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
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
     * Deletes an existing SysEavAttributes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the SysEavAttributes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return SysEavAttributes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysEavAttributes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
    }
}
