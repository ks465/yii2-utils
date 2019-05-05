<?php


namespace khans\utils\demos\controllers;

use khans\utils\controllers\KHanWebController;
use khans\utils\demos\data\MultiFormatEav;
use khans\utils\demos\data\MultiFormatEavSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * EavSampleController implements the CRUD actions for MultiFormatEav model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980121
 * @since   1.0
 */
class EavSampleController extends KHanWebController
{
    /**
     * Lists all MultiFormatEav models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MultiFormatEavSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        vdd(1);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MultiFormatEav model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "EAV Sample Data #" . $model->pk_column,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::a('ویرایش', ['update', 'id' => $model->pk_column],
                        ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the MultiFormatEav model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return MultiFormatEav the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MultiFormatEav::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }

    /**
     * Creates a new MultiFormatEav model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MultiFormatEav();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'   => "افزودن به EAV Sample Data تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', [
                            'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                        ]) .
                        Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit']),

                ];
            } else {
                if ($model->load($request->post()) && $model->save()) {
                    return [
                        'forceReload' => '#multi-format-eav-datatable-pjax',
                        'title'       => "افزودن EAV Sample Data تازه",
                        'content'     => '<span class="text-success">افزودن EAV Sample Data موفق</span>',
                        'footer'      => Html::button('ببند', [
                                'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                            ]) .
                            Html::a('افزودن بیشتر', ['create'], [
                                'class' => 'btn btn-primary', 'role' => 'modal-remote',
                            ]),
                    ];
                } else {
                    return [
                        'title'   => "افزودن EAV Sample Data تازه",
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'  => Html::button('ببند', [
                                'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                            ]) .
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit']),
                    ];
                }
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->pk_column]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing MultiFormatEav model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'   => "ویرایش EAV Sample Data #" . $model->pk_column,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', [
                            'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                        ]) .
                        Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit']),
                ];
            } else {
                if ($model->load($request->post()) && $model->save()) {
                    return [
                        'forceReload' => '#multi-format-eav-datatable-pjax',
                        'title'       => "EAV Sample Data #" . $id,
                        'content'     => $this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer'      => Html::button('ببند', [
                                'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                            ]) .
                            Html::a('ویرایش', ['update', 'id' => $id],
                                ['class' => 'btn btn-primary', 'role' => 'modal-remote']
                            ),
                    ];
                } else {
                    return [
                        'title'   => "ویرایش EAV Sample Data #" . $id,
                        'content' => $this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer'  => Html::button('ببند', [
                                'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                            ]) .
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit']),
                    ];
                }
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->pk_column]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing EAV Sample Data model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['forceClose' => true, 'forceReload' => '#multi-format-eav-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing MultiFormatEav model.
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
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['forceClose' => true, 'forceReload' => '#multi-format-eav-datatable-pjax'];
        } else {
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
        $dataProvider = new ActiveDataProvider([
            'db'    => Yii::$app->get('test'),
            'query' => $model->getActionHistory(),
        ]);

        return [
            'title'   => "رکورد #" . $model->id . ' جدول EAV Sample Data',
            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
        ];
    }
}
