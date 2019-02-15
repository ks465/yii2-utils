<?php


namespace khans\utils\tools\controllers;

use khans\utils\controllers\KHanWebController;
use khans\utils\tools\models\search\SysEavValuesSearch;
use khans\utils\tools\models\SysEavAttributes;
use khans\utils\tools\models\SysEavValues;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * EavValuesController implements the CRUD actions for SysEavValues model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-971126
 * @since   1.0
 */
class EavValuesController extends KHanWebController
{
    /**
     * Lists all SysEavValues models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysEavValuesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysEavValues model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "EAV Values Table #" . $model->id,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::a('ویرایش', ['update', 'id' => $id],
                        ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the SysEavValues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return SysEavValues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysEavValues::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }

    /**
     * Creates a new SysEavValues model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new SysEavValues();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'   => "افزودن به EAV Values Table تازه",
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
                        'forceReload' => '#sys-eav-values-datatable-pjax',
                        'title'       => "افزودن EAV Values Table تازه",
                        'content'     => '<span class="text-success">افزودن EAV Values Table موفق</span>',
                        'footer'      => Html::button('ببند', [
                                'class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal',
                            ]) .
                            Html::a('افزودن بیشتر', ['create'], [
                                'class' => 'btn btn-primary', 'role' => 'modal-remote',
                            ]),
                    ];
                } else {
                    return [
                        'title'   => "افزودن EAV Values Table تازه",
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing SysEavValues model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
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
                    'title'   => "ویرایش EAV Values Table #" . $model->id,
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
                        'forceReload' => '#sys-eav-values-datatable-pjax',
                        'title'       => "EAV Values Table #" . $id,
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
                        'title'   => "ویرایش EAV Values Table #" . $id,
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing EAV Values Table model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
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

            return ['forceClose' => true, 'forceReload' => '#sys-eav-values-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing SysEavValues model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     * @throws NotFoundHttpException
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

            return ['forceClose' => true, 'forceReload' => '#sys-eav-values-datatable-pjax'];
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
        $dataProvider = new ActiveDataProvider(['query' => $model->getActionHistory()]);

        return [
            'title'   => "رکورد #" . $model->id . ' جدول EAV Values Table',
            'content' => $this->renderAjax('@khan/tools/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
        ];
    }

    /**
     * Search attributes in the EAV attributes table by name or label
     *
     * @param string $q part of title/name field of the parent referee table
     *
     * @return array
     */
    public function actionParents($q)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = SysEavAttributes::find()
            ->getTitle('text')
            ->orWhere(['like', 'attr_name', $q])
            ->orWhere(['like', 'attr_label', $q])
            ->orderBy(['attr_label' => SORT_ASC,]);

        $out['results'] = $query->all();

        return $out;
    }

    /**
     * Search attributes in the EAV attributes table by table name
     *
     * @param string $q part of title/name field of the parent referee table
     *
     * @return array
     */
    public function actionTables($q)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = SysEavAttributes::find()
            ->select(['id' => 'MIN([[id]])', 'text' => 'entity_table'])
            ->orWhere(['like', 'entity_table', $q])
            ->orderBy(['entity_table' => SORT_ASC,])
            ->groupBy(['entity_table'])
            ->asArray();

        $out['results'] = $query->all();

        return $out;
    }
}
