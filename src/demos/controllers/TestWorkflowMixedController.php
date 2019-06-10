<?php

namespace khans\utils\demos\controllers;

use Yii;
use khans\utils\demos\data\TestWorkflowMixed;
use khans\utils\demos\data\TestWorkflowMixedSearch;
use yii\data\ActiveDataProvider;
use khans\utils\controllers\KHanWebController;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * TestWorkflowMixedController implements the CRUD actions for TestWorkflowMixed model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980121
 * @since   1.0
 */
class TestWorkflowMixedController extends KHanWebController
{
    /**
     * Lists all TestWorkflowMixed models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestWorkflowMixedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestWorkflowMixed model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'   => "Test Workflow Mixed #" . $model->title,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::a('ویرایش', ['update', 'id' => $model->id],
                                ['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new TestWorkflowMixed model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new TestWorkflowMixed();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'   => "افزودن به Test Workflow Mixed تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#test-workflow-mixed-datatable-pjax',
                    'title'       => "افزودن Test Workflow Mixed تازه",
                    'content'     => '<span class="text-success">افزودن Test Workflow Mixed موفق</span>',
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']).
                            Html::a('افزودن بیشتر', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            }else{
                return [
                    'title'   => "افزودن Test Workflow Mixed تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing TestWorkflowMixed model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'   => "ویرایش Test Workflow Mixed #" . $model->title,
                    'content' =>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#test-workflow-mixed-datatable-pjax',
                    'title'       => "Test Workflow Mixed #".$id,
                    'content'     => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                        Html::a('ویرایش', ['update', 'id' => $id],
                            ['class' => 'btn btn-primary', 'role'=>'modal-remote']
                        )
                ];
            }else{
                 return [
                    'title'   => "ویرایش Test Workflow Mixed #".$id,
                    'content' =>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند',['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                        Html::button('بنویس',['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Test Workflow Mixed model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#test-workflow-mixed-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing TestWorkflowMixed model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#test-workflow-mixed-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

//    /**
//     * Show history of changes in the given record
//     *
//     * @param integer $id
//     *
//     * @return array AJAX grid view of changes in the given record
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionAudit($id)
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//
//        $model = $this->findModel($id);
//        $dataProvider = new ActiveDataProvider(['query' => $model->getActionHistory()]);
//
//        return [
//            'title'   => "رکورد #" . $model->id . ' جدول Test Workflow Mixed',
//            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
//                'dataProvider' => $dataProvider,
//            ]),
//            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
//        ];
//    }


    /**
     * Finds the TestWorkflowMixed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return TestWorkflowMixed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestWorkflowMixed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
