<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:33
 */


namespace khans\utils\tests\demos;


use app\models\UpsertAggr;
use app\models\UpsertAggrSearch;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use khans\utils\components\Jalali;
use khans\utils\widgets\DatePicker;
use khans\utils\widgets\DateRangePicker;
use khans\utils\widgets\GridView;
use Yii;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

require_once Yii::getAlias('@vendor/fzaninotto/faker/src/autoload.php');

class TestWidgets extends BaseTester
{
    protected $skipTests = [
//        'testDatePicker1', 'testDatePicker1_1', 'testDatePicker2', 'testDatePicker3', 'testDatePicker4',
//        'testDatePicker5', 'testDatePicker6', 'testDatePicker7', 'testDatePicker8', 'testDatePicker9',
//        'testDatePicker10', 'testDatePicker11', 'testDatePicker12', 'testDateRangePicker1',
//        'testDateRangePicker2', 'testGridView', 'testAjaxGridView',
    ];

    //<editor-fold Desc="DatePicker">
    public function testDatePicker1()
    {
        $this->writeHeader('1. Only attribute and model are set. Without a form');

        echo DatePicker::widget([
            'id'        => 'test-picker-id',
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'todayBtn' => false,
            ],
        ]);
    }

    public function testDatePicker1_1()
    {
        $this->writeHeader('1. Only attribute and model are set. With a form');

        $form = ActiveForm::begin();
        echo $form->field(
            new DynamicModel(['from_date' => Jalali::date('Y/m', time())]),
            'from_date'
        )
            ->widget(
                DatePicker::className(), [
                'options'     => [
                    'format'     => 'yyyy/mm/dd',
                    'viewformat' => 'yyyy/mm/dd',
                    'placement'  => 'left',
                    'todayBtn'   => 'linked',
                ],
                'htmlOptions' => [
                    'id'    => 'date',
                    'class' => 'form-control',
                ],
            ]);
        $form->end();
    }

    public function testDatePicker2()
    {
        $this->writeHeader('2. Min view: days.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'minViewMode' => 'days',
            ],
        ]);
    }

    public function testDatePicker3()
    {
        $this->writeHeader('3. Min view: months.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m', time())]),
            'options'   => [
                'minViewMode' => 'months',
            ],
        ]);
    }

    public function testDatePicker4()
    {
        $this->writeHeader('4. Min view: years.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y', time())]),
            'options'   => [
                'minViewMode' => 'years',
            ],
        ]);
    }

    public function testDatePicker5()
    {
        $this->writeHeader('5. Format: yyyy.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'format' => 'yyyy',
            ],
        ]);
    }

    public function testDatePicker6()
    {
        $this->writeHeader('6. Format: yyyy/mm.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'format' => 'yyyy/mm',
            ],
        ]);
    }

    public function testDatePicker7()
    {
        $this->writeHeader('7. Format: yyyy/mm/dd.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'format' => 'yyyy/mm/dd',
            ],
        ]);
    }

    public function testDatePicker8()
    {
        $this->writeHeader('8. Min view: years + Format: yyyy/mm/dd.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'minViewMode' => 'years',
                'format'      => 'yyyy/mm/dd',
            ],
        ]);
    }

    public function testDatePicker9()
    {
        $this->writeHeader('9. Min view: months + Format: yyyy/mm/dd.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'minViewMode' => 'months',
                'format'      => 'yyyy/mm/dd',
            ],
        ]);
    }

    public function testDatePicker10()
    {
        $this->writeHeader('10. Min view: days + Format: yyyy/mm.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'minViewMode' => 'days',
                'format'      => 'yyyy/mm',
            ],
        ]);
    }

    public function testDatePicker11()
    {
        $this->writeHeader('11. Start Date: 1345/01/01');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'startDate' => '1345/06/18',
            ],
        ]);
    }

    public function testDatePicker12()
    {
        $this->writeHeader('12. Todat Button: False + Start Date: 1345/06/18 + End Date: 1388/01/01');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m', time())]),
            'options'   => [
                'startDate' => '1345/06/18',
                'endDate'   => '1388/01/01',
                'todayBtn'  => false,
            ],
        ]);
    }
    //</editor-fold>

    //<editor-fold Desc="DateRangePicker">
    public function testDateRangePicker1()
    {
        $this->writeHeader('1. DateRangePicker without a form');

        echo DateRangePicker::widget([
            'id'        => 'attribute-one',
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'minDate' => '1395/01/01',
                'maxDate' => '1398/12/29',
            ],
        ]);
    }

    public function testDateRangePicker2()
    {
        $this->writeHeader('2. DateRangePicker with a form');
        $form = ActiveForm::begin();
        $model = new DynamicModel(['date_range']);
        if (Yii::$app->request->isPost) {
            $value = Yii::$app->request->post();
            $model->load($value);
            $this->writeHeader('[DynamicModel] => [ [date_range] => 1397/08/01 - 1397/09/31]');
        }

        echo $form->field($model, 'date_range')->widget(DateRangePicker::classname(), [
            'id'      => 'form-one',
            'options' => [
                'minDate' => '1395/01/01',
                'maxDate' => '1398/12/29',
            ],
        ]);
        echo Html::submitButton('view');
        $form->end();
    }
    //</editor-fold>

    //<editor-fold Desc="GridView">
    private function buildGridData()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);
        $output = [];
        for ($i = 0; $i < 100; $i++) {
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

    private function firstRow()
    {
        return [
            [
                'content' => 'Group 1',
                'options' => [
                    'colspan' => 3,
                    'class'   => 'text-center skip-export',
                ],
            ],
            [
                'content' => 'Group 2',
                'options' => [
                    'colspan' => 2,
                    'class'   => 'text-center',
                ],
            ],
            [
                'content' => 'Group 3',
                'options' => [
                    'colspan' => 2,
                    'class'   => 'text-center',
                ],
            ],
            [
                'content' => 'Group 4',
                'options' => [
                    'colspan' => 2,
                    'class'   => 'text-center skip-export',
                ],
            ],
        ];
    }

    private function configWidgetModel($id, $dropdown1, $dropdown2)
    {
        $model = new UpsertAggrSearch();

        return [
            'id'           => $id,
            'dataProvider' => $model->search(Yii::$app->request->queryParams),
            'filterModel'  => $model,
            'columns'      => [
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                ],
                [
                    'class' => 'khans\utils\columns\RadioColumn',
                ],
                [
                    'class' => 'kartik\grid\SerialColumn',
                ],
                [
                    'attribute' => 'field',
                    'class'     => 'khans\utils\columns\DataColumn',
                ],
                [
                    'attribute'  => 'year',
                    'class'      => 'khans\utils\columns\DataColumn',
                    'filterType' => 'khans\utils\widgets\DatePicker',
                ],
                [
                    'class'     => 'khans\utils\columns\DataColumn',
                    'attribute' => 'grade',
                ],
                [
                    'class'     => 'khans\utils\columns\EnumColumn',
                    'attribute' => 'status',
                    'enum'      => UpsertAggr::getStatuses(),
                ],
                [
                    'class'          => 'khans\utils\columns\ActionColumn',
                    'runAsAjax'      => $dropdown1,
                    'dropdown'       => $dropdown1,
                    'dropdownButton' => ['class' => 'btn btn-default alert-success', 'label' => 'GoOn'],
                    'header'         => 'Extra Actions',
                    'visibleButtons' => [
                        'view'     => false,
                        'update'   => false,
                        'delete'   => false,
                        'download' => false,
                        'audit'    => true,
                    ],
                    'extraItems'     => $this->buildExtras(),
                ],
                [
                    'class'          => 'khans\utils\columns\ActionColumn',
                    'audit'          => true,
                    'runAsAjax'      => $dropdown2,
                    'viewOptions'    => [
                        'runAsAjax' => $dropdown1,
                    ],
                    'dropdown'       => $dropdown2,
                    'download'       => Url::to(['/my-action', 'id' => 124]),
                    'dropdownButton' => ['class' => 'btn btn-danger'],
                ],
            ],
            'title'        => 'Testing Action Columns -- Model',
            'footer'       => 'Data is generated using `Fake` extension.',
            'before'       => 'This is `before` place holder.',
            'after'        => 'This is `after` place holder.',
            'rowOptions'   => function($model, $index, $widget, $grid) {
                if ($model['field'] == 2012) {
                    return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
                }

                return [];
            },
            'beforeHeader' => [
                [
                    'columns' => $this->firstRow(),
                ],
            ],
            'bulkAction'   => [
                'action'  => 'some-action',
                'label'   => 'Do Somthing',
                'icon'    => 'send',
                'class'   => '',
                'message' => '',
            ],
        ];
    }

    private function configWidget($id, $dropdown1, $dropdown2)
    {
        $model = new DynamicModel(['a', 'b', 'c', 'd', 'e']);
        $model->addRule(['a', 'b', 'c', 'd', 'e'], 'safe');

        return [
            'id'           => $id,
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildGridData()]),
            'filterModel'  => $model,
            'columns'      => [
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                ],
                [
                    'class' => 'khans\utils\columns\RadioColumn',
                ],
                [
                    'class' => 'kartik\grid\SerialColumn',
                ],
                [
                    'attribute' => 'a',
                    'class'     => 'khans\utils\columns\DataColumn',
                ],
                [
                    'attribute' => 'b',
                    'class'     => 'khans\utils\columns\DataColumn',
                ],
                [
                    'class'      => 'khans\utils\columns\BooleanColumn',
                    'attribute'  => 'e',
//                    'trueIcon'  => 'PhD',
//                    'trueLabel'  => 'PhD',
//                    'falseLabel' => 'MSc',
                ],
                [
                    'class'  => 'kartik\grid\FormulaColumn',
                    'header' => 'Formula Column',
                    'vAlign' => 'middle',
                    'hAlign' => 'right',
                    'width'  => '7%',
                    'value'  => function($model, $key, $index, $widget) {
                        $p = compact('model', 'key', 'index');

                        return $widget->col(4, $p) % 100;
                    },
                ],
                [
                    'class'          => 'khans\utils\columns\ActionColumn',
                    'runAsAjax'      => $dropdown1,
                    'audit'          => true,
                    'dropdown'       => $dropdown1,
                    'dropdownButton' => ['class' => 'btn btn-default alert-success', 'label' => 'GoOn'],
                    'header'         => 'Extra Actions',
                    'visibleButtons' => [
                        'view'     => false,
                        'update'   => false,
                        'delete'   => false,
                        'download' => false,
                        'audit'    => true,
                    ],
                    'extraItems'     => $this->buildExtras(),
                ],
                [
                    'class'          => 'khans\utils\columns\ActionColumn',
                    'runAsAjax'      => $dropdown2,
                    'audit'          => true,
                    'viewOptions'    => [
                        'runAsAjax' => $dropdown1,
                    ],
                    'deleteAlert'    => 'رکورد انتخاب شده از فهرست داده‌ها پاک خواهد شد.',
                    'dropdown'       => $dropdown2,
                    'download'       => Url::to(['/my-action', 'id' => 124]),
                    'dropdownButton' => ['class' => 'btn btn-danger'],
                ],
            ],
            'title'        => 'Testing Action Columns -- Array',
            'rowOptions'   => function($model, $index, $widget, $grid) {
                if ($model['b'] == 1993) {
                    return ['class' => 'alert-danger text-danger'];
                }
                if ($model['b'] > 2000) {
                    return ['class' => 'alert-success text-success'];
                }

                return [];
            },
            'beforeHeader' => [
                [
                    'columns' => $this->firstRow(),
                ],
            ],
            'bulkAction'   => [
                'action'  => 'some-action',
                'label'   => 'Do Somthing',
                'icon'    => 'send',
                'class'   => '',
                'message' => '',
            ],
        ];
    }

    private function buildExtras()
    {
        return [
            'name'   => [
                'icon'   => 'edit',
                'action' => 'otherAction',
                'config' => ['class' => 'alert-danger text-success'],
            ],
            [],
            'rename' => [
                'title'  => 'Test Me',
                'icon'   => 'pencil',
                'config' => ['class' => 'alert-success text-success'],
            ],
            'reset'  => [
                'runAsAjax' => false,
            ],
        ];
    }

    public function testGridView()
    {
        $this->writeHeader('GridView; ExtraActions in dropdown & run as ajax; Actions as icons & run normal; Reset extra action never runs as ajax. View runs as ajax.');
        $config = $this->configWidget('normal-test', true, false);
        $config['showRefreshButtons'] = true;
        $config['createAction'] = true;
        $config['type'] = 'primary';
        $config['itemLabelSingle'] = 'primary';

        vd($config);
        echo GridView::widget($config);
    }

    public function testAjaxGridView()
    {
        $this->writeHeader('GridView; ExtraActions as icons & run normal; Actions in dropdowns & run as ajax; Reset extra action never runs as ajax. View runs normal.');
        $config = $this->configWidgetModel('pjax-test', false, true);
        $config['type'] = 'danger';
        $config['itemLabelSingle'] = 'danger';
        $config['itemLabelMany'] = 'dangerMM';
        $config['itemLabelPlural'] = 'dangerSS';
        $config['itemLabelFew'] = 'dangerFF';
        $config['showRefreshButtons'] = true;
        $config['createAction'] = false;

        vd($config);
        echo GridView::widget($config);
    }
    //</editor-fold>

    //<editor-fold Desc="Export Component">
    public function testExportArray()
    {
        $this->writeHeader('Stand alone export menu with array data.');
        echo ExportMenu::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildGridData()]),
//            'columns' => $this->columns,
        ]);
    }

    public function testExportModel()
    {
        $this->writeHeader('Stand alone export menu with model data.');
        $model = new UpsertAggrSearch();
        echo ExportMenu::widget([
            'dataProvider' => $model->search(Yii::$app->request->queryParams),
//            'columns' => $this->columns,
        ]);
    }

    public function testGridViewExport()
    {
        $this->writeHeader('GridView; ExtraActions as icons & run normal; Actions in dropdowns & run as ajax; Reset extra action never runs as ajax. View runs normal.');
        $config = $this->configWidget('export-test', false, true);
        $config['title'] = 'Testing Export Component';
        $config['afterHeader'] = $config['beforeHeader'];
        $config['afterHeader'][0]['options'] = ['class' => ' skip-export '];
        //$config['beforeFooter'] = $config['beforeHeader'];
        //$config['afterFooter'] = $config['beforeHeader'];
        $config['createAction'] = [
            'action'  => 'create',
            'ajax'=> false,
        ];

        vd($config);

        $config['export'] = true;
        echo GridView::widget($config);
    }
    //</editor-fold>
}
