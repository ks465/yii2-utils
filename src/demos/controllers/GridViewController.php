<?php


namespace khans\utils\demos\controllers;


use kartik\growl\Growl;
use khans\utils\demos\data\MultiFormatDataSearch;
use khans\utils\models\KHanModel;
use khans\utils\widgets\DropdownX;
use khans\utils\widgets\GridView;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Class GridViewController shows multiple demo --AND Test-- pages for GridView
 *
 * @package KHanS\Utils
 * @version 0.1.0-980128
 * @since   1.0
 */
class GridViewController extends KHanWebController
{
    //<editor-fold Desc="STD Response Actions">
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal View",
                'content' => $this->renderAjax('view', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('view', ['id' => $id]);
        }
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Update",
                'content' => $this->renderAjax('update', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('update', ['id' => $id]);
        }
    }

    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Delete",
                'content' => 'Delete action completed successfully: ' . $id,
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            Yii::$app->session->addFlash('success', 'Delete action completed successfully: ' . $id);

            return $this->redirect(['index']);
        }
    }

    public function actionRename($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Rename",
                'content' => $this->renderAjax('rename', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('rename', ['id' => $id]);
        }
    }

    public function actionReset($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            echo Growl::widget([
                'title' => 'AJAX + Modal Response Failed.',
                'body'  => 'AJAX + Modal action is not available for this action.',
            ]);

            return $this->refresh();
        } else {
            return $this->render('reset', ['id' => $id]);
        }
    }
    //</editor-fold>

    //<editor-fold Desc="Bulk Response Actions">
    public function actionViewB()
    {
        $request = Yii::$app->request;
        $id = $request->post('pks');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal View",
                'content' => $this->renderAjax('view', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('view', ['id' => $id]);
        }
    }

    public function actionUpdateB()
    {
        $request = Yii::$app->request;
        $id = $request->post('pks');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Update",
                'content' => $this->renderAjax('update', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('update', ['id' => $id]);
        }
    }

    public function actionRenameB()
    {
        $request = Yii::$app->request;
        $id = $request->post('pks');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Rename",
                'content' => $this->renderAjax('rename', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('rename', ['id' => $id]);
        }
    }

    public function actionResetB()
    {
        $request = Yii::$app->request;
        $id = $request->post('pks');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "This is Bare Metal Reset",
                'content' => $this->renderAjax('reset', ['id' => $id]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('reset', ['id' => $id]);
        }
    }
    //</editor-fold>

    //<editor-fold Desc="Demos">
    public function actionExtraHeader()
    {
        $columns = $this->getSimpleDataColumns();
        $config['beforeHeader'] = [
            [
                'columns' => $this->firstRow(),
            ],
            [
                'columns' => $this->secondRow(),
            ],
        ];

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'First Header Row',
            'description'  => 'Add additional row of header',
            'config'       => $config,
        ]);
    }

    private function getSimpleDataColumns()
    {
        return [
            'checkbox' => [
                'class' => 'kartik\grid\CheckboxColumn',
            ],
            'radio'    => [
                'class' => 'khans\utils\columns\RadioColumn',
            ],
            'serial'   => [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'a'        => [
                'attribute' => 'a',
                'class'     => 'khans\utils\columns\DataColumn',
                'width'     => '100px',
            ],
            'b'        => [
                'attribute' => 'b',
                'class'     => 'khans\utils\columns\DataColumn',
                'width'     => '100px',
            ],
            'e'        => [
                'class'     => 'khans\utils\columns\BooleanColumn',
                'attribute' => 'e',
                'width'     => '100px',
            ],
            'action'   => [
                'class'     => 'khans\utils\columns\ActionColumn',
                'runAsAjax' => true,
                'dropdown'  => false,
            ],
        ];
    }

    private function firstRow()
    {
        return [
            [
                'content' => 'Control',
                'options' => [
                    'colspan' => 3,
                    'class'   => 'text-center skip-export',
                ],
            ],
            [
                'content' => 'Data ID',
                'options' => [
                    'colspan' => 3,
                    'class'   => 'text-center',
                ],
            ],
            [
                'content' => 'Action',
                'options' => [
                    'colspan' => 1,
                    'rowspan' => 2,
                    'class'   => 'text-center skip-export text-danger text-bold',
                    'style'   => 'vertical-align: middle;',
                ],
            ],
        ];
    }

    private function secondRow()
    {
        return [
            [
                'content' => 'Select',
                'options' => [
                    'colspan' => 2,
                    'class'   => 'text-center skip-export',
                ],
            ],
            [
                'content' => '#',
                'options' => [
                    'colspan' => 1,
                    'class'   => 'text-center skip-export',
                ],
            ],
            [
                'content' => 'Title',
                'options' => [
                    'colspan' => 2,
                    'class'   => 'text-center',
                ],
            ],
            [
                'content' => 'Result',
                'options' => [
                    'colspan' => 1,
                    'class'   => 'text-center skip-export',
                ],
            ],
//            [
//                'content' => '',
//                'options' => [
//                    'colspan' => 1,
//                    'class'   => 'text-center skip-export',
//                ],
//            ],
        ];
    }

    private function buildSimpleGridData($requestedRecords = 100)
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);
        $output = [];
        for ($i = 0; $i < $requestedRecords; $i++) {
            $output[] = [
                'a'          => $faker->name,
                'b'          => $faker->year,
                'c'          => $faker->text(5),
                'd'          => $faker->numberBetween(6, 9),
                'e'          => $faker->boolean(75),
                'created_by' => $faker->firstName,
                'created_at' => $faker->unixTime,
                'updated_by' => $faker->firstName,
                'updated_at' => $faker->unixTime,
            ];
        }

        return $output;
    }

    public function actionExportTrue()
    {
        $columns = $this->getSimpleDataColumns();
        $config['export'] = true;

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Export True',
            'description'  => '`export` config is set to `TRUE`',
            'config'       => $config,
        ]);
    }

    public function actionExportMenu()
    {
        $columns = $this->getSimpleDataColumns();
        $config['export'] = GridView::EXPORTER_MENU;

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Export Menu',
            'description'  => '`export` config is set to `GridView::EXPORTER_MENU`',
            'config'       => $config,
        ]);
    }

    public function actionExportSimple()
    {
        $columns = $this->getSimpleDataColumns();
        $config['export'] = GridView::EXPORTER_SIMPLE;

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Export Simple',
            'description'  => '`export` config is set to `GridView::EXPORTER_SIMPLE`',
            'config'       => $config,
        ]);
    }

    public function actionSearchModel()
    {
        $searchModel = new MultiFormatDataSearch();

        $config['filterModel'] = $searchModel;
        $config['showRefreshButtons'] = true;
        $config['afterHeader'] = [
            [
                'columns' => [
                    [
                        'content' => 'Filter -->',
                        'options' => [
                            'colspan' => 2,
                            'class'   => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `=` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `LIKE` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `<`, `>`, `<=`, or `>=` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `=` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `???` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `=` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                    [
                        'content' => 'Uses `=` to compare',
                        'options' => [
                            'class' => 'text-center text-warning skip-export small kv-align-middle',
                        ],
                    ],
                ],
            ],
        ];

        return $this->render('grid', [
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            'columns'      => $this->getTableDataColumns(),
            'title'        => 'Search Model',
            'description'  => 'Testing Search Model and Columns\' Filters',
            'config'       => $config,
        ]);
    }
    //</editor-fold>

    //<editor-fold Desc="Configs">

    private function getTableDataColumns()
    {
        return [
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '20px',
            ],
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '30px',
            ],
            [
                'class'          => '\khans\utils\columns\DataColumn',
                'attribute'      => 'integer_column',
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'width'          => '100px',
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ],
            [
                'class'          => '\khans\utils\columns\DataColumn',
                'attribute'      => 'text_column',
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'width'          => '150px',
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ],
            [
                'class'          => '\khans\utils\columns\ArithmeticColumn',
                'attribute'      => 'real_column',
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'width'          => '100px',
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ],
            [
                'class'     => '\khans\utils\columns\BooleanColumn',
                'attribute' => 'boolean_column',
                'width'     => '100px',
            ],
            [
                'class'          => '\khans\utils\columns\JalaliColumn',
                'attribute'      => 'timestamp_column',
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'width'          => '200px',
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ],
            [
                'class'     => '\khans\utils\columns\EnumColumn',
                'attribute' => 'status',
                'enum'      => KHanModel::getStatuses(),
                'width'     => '100px',
            ],
            [
                'class'     => '\khans\utils\columns\ProgressColumn',
                'attribute' => 'progress_column',
                'width'     => '100px',
            ],
        ];
    }

    public function actionBulkAction()
    {
        $columns = $this->getSimpleDataColumns();
        $config['bulkAction'] = $this->getBulkAction();

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Bulk Action',
            'description'  => 'Add additional Route to Actions Using BulkAction',
            'config'       => $config,
        ]);
    }

    private function getBulkAction()
    {
        return [
            'dropdown' => true,
            'action'   => DropdownX::widget([
                'items' => [
                    [
                        'label' => 'عنوان منوی اصلی',
                    ],
                    [
                        'label'   => 'View',
                        'url'     => 'view-b',
                        'message' => 'پیام شماره یک',
                        'class'   => 'default',
                    ],
                    [
                        'label'   => 'Update',
                        'url'     => 'update-b',
                        'message' => 'پیام شماره پنج',
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => 'کلید زیرمنوی یکم',
                        'class' => 'danger',
                        'items' => [
                            [
                                'label' => 'عنوان منوی فرعی',
                            ],
                            [
                                'label'   => 'دستور سه',
                                'url'     => 'rename-b',
                                'message' => 'پیام شماره سه',
                                'class'   => 'danger',
                            ],
                            [
                                'label'   => 'دستور',
                                'message' => 'پیام شماره چهار',
                                'url'     => 'reset-b',
                            ],
                        ],
                    ],
                ],
            ]),
        ];
    }

    public function actionDropdownAction()
    {
        $columns = $this->getSimpleDataColumns();
        unset($columns['checkbox']);
        unset($columns['radio']);
        $columns['action'] = $this->getActionColumn();
        $columns['action']['runAsAjax'] = false;
        $columns['action']['viewOptions']['runAsAjax'] = true;
        $columns['action']['updateOptions']['runAsAjax'] = true;

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Dropdown Action Menu',
            'description'  => 'Testing Action Columns in Dropdown Menu-- Array',
        ]);
    }

    private function getActionColumn()
    {
        return [
            'class'          => 'khans\utils\columns\ActionColumn',
            'runAsAjax'      => true,
            'dropdown'       => true,
            'dropdownButton' => [
                'class' => 'btn btn-default alert-success', 'label' => '<i class="glyphicon glyphicon-cog"></i>',
            ],
            'header'         => 'Extra Actions',
            'visibleButtons' => [
                'view'     => true,
                'update'   => true,
                'delete'   => true,
                'download' => false,
                'audit'    => false,
            ],
            'extraItems'     => [
                'rename' => [
                    'title' => 'Rename Me',
                    'icon'  => 'list',
                ],
                'reset'  => [
                    'title'     => 'This is not Modal!',
                    'config'    => ['class' => 'text-danger'],
                    'runAsAjax' => false,
                ],
            ],
        ];
    }

    public function actionDisabledActions()
    {
        $columns = $this->getSimpleDataColumns();
        unset($columns['checkbox']);
        unset($columns['radio']);
        $columns['action'] = $this->getActionColumn();

        $columns['action']['extraItems']['rename']['disabled'] = function($model) { return $model['e']; };

        $columns['action']['visibleButtons']['reset'] = function($model) { return $model['e']; };
        $columns['action']['visibleButtons']['update'] = function($model) { return $model['e']; };
        $columns['action']['visibleButtons']['delete'] = function($model) { return $model['e']; };

        $columns['action']['runAsAjax'] = false;
        $columns['action']['viewOptions']['runAsAjax'] = true;
        $columns['action']['updateOptions']['runAsAjax'] = true;
        
        $columns['action2'] = $columns['action'];
        $columns['action2']['dropdown'] = false;
        $columns['action2']['header'] = 'Linear Copy';

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData()]),
            'columns'      => $columns,
            'title'        => 'Disable or hide `extraItems` using model properties',
            'description'  => 'Inline Actions are disabled or hide through ActionColumn `disabled` and `visibleButtons` properties.' .
                ' <strong>STD buttons can not be disabled currently.</strong>' .
                '<p><strong>Do NOT use `visibleButtons` for extraItems.</strong></p>',
        ]);
    }

    public function actionActionConfirms()
    {
        $columns = ['a', 'b', 'c', 'd', 'e'];
        $columns['action'] = [
            'class'         => '\khans\utils\columns\ActionColumn',
            'runAsAjax'     => true,
            'deleteAlert'   => 'آیا از این پیام برای پاک کردن داده‌ها استفاده می‌نمایید؟',
            'updateOptions' => [
                'role'                 => 'modal-remote',
                'title'                => 'ویرایش داده‌ها با اخطار',
                'data-confirm'         => false, // for override default confirmation
                'data-method'          => false, // for override yii data api
                'data-request-method'  => 'post',
                'data-toggle'          => 'tooltip',
                'data-confirm-title'   => 'ویرایش داده‌های حساس',
                'data-confirm-message' => '<h2 class="text-danger">' . 'این کار غیرقابل برگشت است!' . '</h2>' . 'آیا ادامه می‌دهید؟',
            ],
            'extraItems'    => [
                'with-confirm'    => [
                    'action'  => 'rename',
                    'icon'    => 'question-sign',
                    'title'   => 'Detailed Confirmation',
                    'method'  => 'post',
                    'confirm' => [
                        'title'   => 'آیا از فرستادن این گزینه اطمینان دارید؟',
                        'message' => 'با انجام این عمل:' . '<ul>' .
                            '<li>' .
                            'می‌پذیرم که یک، دو و سه' .
                            '</li>' .
                            '<li>' .
                            'همچنین یازده، دوازده و سیزده' .
                            '</li>' .
                            '</ul>' .
                            'آیا ادامه می‌دهید؟',
                    ],
                ],
                'generic-confirm' => [
                    'action'  => 'rename',
                    'method'  => 'post',
                    'title'   => 'Generic Confirmation',
                    'confirm' => true,
                    'icon'    => 'ok',
                ],
                'no-confirm'      => [
                    'action' => 'rename',
                    'title'  => 'No Confirmation AT ALL',
                    'method' => 'post',
                    'icon'   => 'road',
                ],
            ],
        ];


        $columns['action']['dropdown'] = false;
        $columns['action']['header'] = 'Test Confirms';

        return $this->render('grid', [
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildSimpleGridData(5)]),
            'columns'      => $columns,
            'title'        => 'Test Confirmation for `ExtraItems` Actions',
            'description'  => 'Test generic, detailed, or no confirmation for row actions.',
        ]);
    }
    //</editor-fold>
    protected function findModel($id)
    {
        if (($model = \khans\utils\demos\data\TestWorkflowEvents::findOne(1)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}