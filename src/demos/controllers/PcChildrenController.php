<?php

namespace khans\utils\demos\controllers;

use Yii;
use khans\utils\demos\data\PcChildren;
use khans\utils\demos\data\PcChildrenSearch;
use yii\data\ActiveDataProvider;
use khans\utils\controllers\KHanWebController;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PcChildrenController implements the CRUD actions for PcChildren model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980121
 * @since   1.0
 */
class PcChildrenController extends KHanWebController
{
    /**
     * Lists all PcChildren models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PcChildrenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcChildren model.
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
                    'title'   => "List of data having parent record #" . $model->id,
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
     * Creates a new PcChildren model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PcChildren();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'   => "افزودن به List of data having parent record تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#pc-children-datatable-pjax',
                    'title'       => "افزودن List of data having parent record تازه",
                    'content'     => '<span class="text-success">افزودن List of data having parent record موفق</span>',
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']).
                            Html::a('افزودن بیشتر', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            }else{
                return [
                    'title'   => "افزودن List of data having parent record تازه",
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
     * Updates an existing PcChildren model.
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
                    'title'   => "ویرایش List of data having parent record #" . $model->id,
                    'content' =>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#pc-children-datatable-pjax',
                    'title'       => "List of data having parent record #".$id,
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
                    'title'   => "ویرایش List of data having parent record #".$id,
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
     * Delete an existing List of data having parent record model.
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
            return ['forceClose' => true, 'forceReload' => '#pc-children-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing PcChildren model.
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
            return ['forceClose'=>true,'forceReload'=>'#pc-children-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
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
            'title'   => "رکورد #" . $model->id . ' جدول List of data having parent record',
            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
        ];
    }

    /**
     * React to search component of filter or form looking for list of
     *
     * @param string $q part of title/name field of the parent referee table
     *
     * @return array
     */
    public function actionParentsList($q)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $query = \khans\utils\demos\data\PcParents::find()
            ->getTitle('text')
            ->orWhere(['id' => $q])
            ->orWhere(['like', 'comment', $q])
    ;
        $out['results'] = $query->all();

        return $out;
    }

    /**
     * Finds the PcChildren model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return PcChildren the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcChildren::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
