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
use khans\utils\widgets\ConfirmButton;
use khans\utils\widgets\DatePicker;
use khans\utils\widgets\DateRangePicker;
use khans\utils\widgets\DropdownX;
use khans\utils\widgets\GridView;
use Yii;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class TestWidgets load demo files for the widgets of the yii2-utils package
 *
 * @package khans\utils\tests\demos
 * @version 0.5.0-971009
 * @since   1.0
 */
class TestWidgets extends BaseTester
{
    protected $skipTests = [
//        'testDatePicker1', 'testDatePicker1_1', 'testDatePicker2', 'testDatePicker3', 'testDatePicker4',
//        'testDatePicker5', 'testDatePicker6', 'testDatePicker7', 'testDatePicker8', 'testDatePicker9',
//        'testDatePicker10', 'testDatePicker11', 'testDatePicker12',
//        'testDateRangePicker1', 'testDateRangePicker2',
//        'testGridView', 'testAjaxGridView',
//        'testGridViewDropDownBulkAction',
//        'testConfirmButtonA', 'testConfirmButtonB',
//        'testConfirmButtonC', 'testConfirmButtonD',
//        'testExportArray', 'testExportModel', 'testGridViewExport', 'testGridViewSEExport',
//        'testExportLongModelDefault',
//        'testExportLongModelExportMenu1',
//        'testExportLongModelExportMenu2', 'testExportLongModelExportMenu3',
//        'testExportLongModelExportMenuReal',
//        'testExportLongModelExportMenuSimple',
    ];

    //<editor-fold Desc="ConfirmButton">
    public function testConfirmButtonA()
    {
        $form = ActiveForm::begin([
            'id'     => 'form-a', //mandatory
            'action' => Url::to(['login']), //optional
        ]);

        echo ConfirmButton::widget([
            'type'        => ConfirmButton::TYPE_INFO,
            'formID'      => $form->id,
            'buttonLabel' => 'Load "login" Page with POST',
            'buttonClass' => 'btn btn-info',
            'title'       => 'Modal dialog title',
            'message'     => Html::tag('h3', 'Any tailored message' . '<br/>' .
                    'Which actually could be' .
                    'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
        ]);
        ActiveForm::end();
    }

    public function testConfirmButtonB()
    {
        $form = ActiveForm::begin([
            'id'     => 'form-b', //mandatory
            'action' => Url::to(['form-action']), //optional
        ]);

        echo ConfirmButton::widget([
            'formID'         => $form->id,
            'buttonLabel'    => 'Load "form-action" Page with POST',
            'buttonClass'    => 'btn btn-danger',
            'title'          => 'Modal dialog title',
            'message'        => Html::tag('h3', 'Any tailored message' . '<br/>' .
                    'Which actually could be' .
                    'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
            'btnOKLabel'     => 'Click this to go ahead',
            'btnCancelLabel' => 'Click this to cancel and go back',
            'btnOKIcon'      => 'fire',
            'btnCancelIcon'  => 'time',
        ]);
        ActiveForm::end();
    }

    public function testConfirmButtonC()
    {
        $form = ActiveForm::begin([
            'id'     => 'form-c', //mandatory
            'action' => Url::to(['login']), //optional
        ]);

        echo ConfirmButton::widget([
            'type'        => ConfirmButton::TYPE_SUCCESS,
            'formID'      => $form->id,
            'sendAjax'    => true,
            'buttonLabel' => 'Load "login" Page with AJAX',
            'buttonClass' => 'btn btn-success',
            'title'       => 'modal dialog title',
            'message'     => Html::tag('h3', 'Any tailored message' . '<br/>' .
                    'Which actually could be' .
                    'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
        ]);
        ActiveForm::end();
    }

    public function testConfirmButtonD()
    {
        $form = ActiveForm::begin([
            'id'     => 'form-d', //mandatory
            'action' => Url::to(['form-action']), //optional
        ]);

        echo ConfirmButton::widget([
            'type'           => ConfirmButton::TYPE_PRIMARY,
            'formID'         => $form->id,
            'sendAjax'       => true,
            'buttonLabel'    => 'Load "form-action" Page with AJAX',
            'buttonClass'    => 'btn btn-primary',
            'title'          => 'modal dialog title',
            'message'        => Html::tag('h3', 'Any tailored message' . '<br/>' .
                    'Which actually could be' .
                    'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
            'btnOKLabel'     => 'Click this to go ahead',
            'btnCancelLabel' => 'Click this to cancel and go back',
            'btnOKIcon'      => 'fire',
            'btnCancelIcon'  => 'time',
        ]);
        ActiveForm::end();
    }
    //</editor-fold>

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
                    'attribute' => 'counter',
                    'class'     => 'khans\utils\columns\DataColumn',
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
                if ($model['grade'] == 'PhD') {
                    return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
                }

                return [];
            },
//            'beforeHeader' => [
//                [
//                    'columns' => $this->firstRow(),
//                ],
//            ],
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
                    'class'     => 'khans\utils\columns\BooleanColumn',
                    'attribute' => 'e',
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

    public function testGridViewDropDownBulkAction()
    {
//        $this->writeHeader('GridView; BulkAction with Dropdown, run as Ajax');
//        $config = $this->configWidget('dropdown-test', false, false);
        $this->writeHeader('GridView; BulkAction with Dropdown, run as Normal');
        $config = $this->configWidget('dropdown-test', false, true);
        $config['type'] = 'danger';
        $config['itemLabelSingle'] = 'danger';
        $config['itemLabelMany'] = 'dangerMM';
        $config['itemLabelPlural'] = 'dangerSS';
        $config['itemLabelFew'] = 'dangerFF';
        $config['showRefreshButtons'] = true;
        $config['createAction'] = false;
        $config['bulkAction']['dropdown'] = true;
        $config['bulkAction']['action'] = DropdownX::widget([
            'items' => [
                [
                    'label' => 'عنوان منوی اصلی',
                ],
                [
                    'label'   => 'دستور یک',
                    'url'     => 'index',
                    'message' => 'پیام شماره یک',
                    'class'   => 'default',
                ],
                [
                    'label'   => 'باز هم یک دستور دیگر',
                    'url'     => '#',
                    'message' => 'پیام شماره پنج',
                ],
                '<li class="divider"></li>',
                [
                    'label' => 'کلید زیرمنوی یکم',
                    'class' => 'danger',
                    'items' => [
                        [
                            'label' => 'عنوان زیرمنوی یکم',
                        ],
                        [
                            'label'   => 'دستور سه',
                            'url'     => 'about',
                            'message' => 'پیام شماره سه',
                            'class'   => 'danger',
                        ],
                        [
                            'label'   => 'باز هم دستور',
                            'message' => 'پیام شماره چهار',
                            'url'     => 'login',
                        ],
                    ],
                ],
                '<li class="divider"></li>',
                [
                    'label' => 'عنوان منوی فرعی',
                ],
                [
                    'label' => 'دستور جدا شده',
                    'url'   => '#',
                    'class' => 'success',
                ],
            ],
        ]);

        echo GridView::widget($config);
    }
    //</editor-fold>

    //<editor-fold Desc="Export Component">
    public function fakeDataForSearch()
    {
        return;
        require_once __DIR__ . '/../../vendor/fzaninotto/faker/src/autoload.php';

        $count = 100;
        $faker = \Faker\Factory::create('fa_IR');
        for ($i = 0; $i < $count; $i++) {
            $x = new UpsertAggr();
            $x->grade = $faker->shuffleArray(['Msc', 'PhD'])[0];
            $x->field = $faker->numberBetween(1200, 1300);
            $x->year = $faker->numberBetween(1392, 1394);
            $x->status = $faker->randomLetter;
            $x->counter = $i;
            $x->r_a = $faker->numerify('###.##');
            $x->r_b = $faker->numerify('##.#');
            $x->created_by = 0;
            $x->created_at = time();
            $x->updated_by = 0;
            $x->updated_at = time();
            $x->save();
        }
    }

    public function testExportArray()
    {
        $this->writeHeader('Stand alone export menu with array data. This requires some CSS tweaks. No columns defined.');
        echo ExportMenu::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $this->buildGridData()]),
        ]);
    }

    public function testExportModel()
    {
        $this->writeHeader('Stand alone export menu with model data. This requires some CSS tweaks. No columns defined.');
        $model = new UpsertAggrSearch();
        echo ExportMenu::widget([
            'dataProvider'              => $model->search(Yii::$app->request->queryParams),
            'columnSelectorMenuOptions' => ['class' => 'dropdown-menu-right'],
            'dropdownOptions'           => ['menuOptions' => ['class' => 'dropdown-menu-right']],
            'template'                  => "{menu}\n{columns}",
        ]);
    }

    public function testGridViewExport()
    {
        $this->writeHeader('GridView; export is set to TRUE. Array Data.');
        $config = $this->configWidget('export-test1', false, true);
        $config['title'] = 'Testing Export Component';
        $config['afterHeader'] = $config['beforeHeader'];
        $config['afterHeader'][0]['options'] = ['class' => ' skip-export '];
        $config['createAction'] = [
            'action' => 'create',
            'ajax'   => false,
        ];
        $config['export'] = true;

        echo GridView::widget($config);
    }

    public function testGridViewSEExport()
    {
        $this->writeHeader('GridView; export is set to an instance of ExportMenu. Array Data.');

        $config = $this->configWidget('export-test2', false, true);
        $config['title'] = 'Testing Export Component';
        $config['afterHeader'] = $config['beforeHeader'];
        $config['afterHeader'][0]['options'] = ['class' => ' skip-export '];
        $config['createAction'] = [
            'action' => 'create',
            'ajax'   => false,
        ];

        $config['export'] = ExportMenu::widget([
            'dataProvider'              => $config['dataProvider'],
            'template'                  => "{menu}\n{columns}",
            'columnSelectorMenuOptions' => ['class' => 'dropdown-menu-right'],
            'columnSelectorOptions'     => ['class' => 'btn-info'],
            'dropdownOptions'           => [
                'class'       => 'btn-info',
                'menuOptions' => ['class' => 'dropdown-menu-right'],
            ],
        ]);

        echo GridView::widget($config);
    }

    public function testExportLongModelDefault()
    {
        $this->writeHeader('Default exporter. Exports current page. Respects filters. Includes serial column.');
        $config = $this->configWidgetModel('export-test3', false, true);
        $config['export'] = true;

        echo GridView::widget($config);
    }

    public function testExportLongModelExportMenu1()
    {
        $this->writeHeader('ExportMenu exporter Using same data provider. Exports all pages . Respects filters. This is implemented');
        $config = $this->configWidgetModel('export-test4', false, true);
        $config['export'] = ExportMenu::widget([
            'dataProvider'              => $config['dataProvider'],
            'columnSelectorMenuOptions' => ['class' => 'dropdown-menu-right'],
            'dropdownOptions'           => ['menuOptions' => ['class' => 'dropdown-menu-right']],
            'template'                  => "{menu}\n{columns}",
            'clearBuffers'              => true,
            'initProvider'              => true,
        ]);

        echo GridView::widget($config);
    }

    public function testExportLongModelExportMenu2()
    {
        $this->writeHeader('ExportMenu exporter Using separate data provider with queryParams. Exports all page. Respects filters.');
        $config = $this->configWidgetModel('export-test5', false, true);
        $model = new UpsertAggrSearch();
        $config['export'] = ExportMenu::widget([
            'dataProvider'              => $model->search(Yii::$app->request->queryParams),
            'columnSelectorMenuOptions' => ['class' => 'dropdown-menu-right'],
            'dropdownOptions'           => ['menuOptions' => ['class' => 'dropdown-menu-right']],
            'template'                  => "{menu}\n{columns}",
            'clearBuffers'              => true,
            'initProvider'              => true,
        ]);

        echo GridView::widget($config);
    }

    public function testExportLongModelExportMenu3()
    {
        $this->writeHeader('ExportMenu exporter Using separate data provider without queryParams. Exports all pages. Does NOT respect filters.');
        $config = $this->configWidgetModel('export-test6', false, true);
        $model = new UpsertAggrSearch();
        $config['export'] = ExportMenu::widget([
            'dataProvider'              => $model->search([]),
            'columnSelectorMenuOptions' => ['class' => 'dropdown-menu-right'],
            'dropdownOptions'           => ['menuOptions' => ['class' => 'dropdown-menu-right']],
            'template'                  => "{menu}\n{columns}",
            'clearBuffers'              => true,
            'initProvider'              => true,
        ]);

        echo GridView::widget($config);
    }

    public function testExportLongModelExportMenuReal()
    {
        $this->writeHeader('ExportMenu Widget Using the same data provider without queryParams. Exports all pages. Does respect filters. Drops serial column');
        $config = $this->configWidgetModel('export-test6', false, true);
        $config['showRefreshButtons'] = true;
        $config['bulkAction'] = false;

        $config['export'] = \khans\utils\widgets\ExportMenu::widget([
            'dataProvider' => $config['dataProvider'],
        ]);

        echo GridView::widget($config);
    }

    public function testExportLongModelExportMenuSimple()
    {
        $this->writeHeader('ExportMenu Widget Using the same data provider without queryParams. Exports all pages. Does respect filters. Drops serial column');
        $config = $this->configWidgetModel('export-test6', false, true);
        $config['showRefreshButtons'] = true;
        $config['bulkAction'] = false;

        $config['export'] = GridView::EXPORTER_MENU;

        echo GridView::widget($config);
    }
    //</editor-fold>
}
