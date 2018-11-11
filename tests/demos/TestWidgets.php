<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:33
 */


namespace KHanS\Utils\tests\demos;


use KHanS\Utils\components\Jalali;
use KHanS\Utils\widgets\AjaxGridView;
use KHanS\Utils\widgets\DatePicker;
use KHanS\Utils\widgets\GridView;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

class TestWidgets extends BaseTester
{
    //<editor-fold Desc="DatePicker">
    public function testDatePicker1()
    {
        $this->writeHeader('1. Only attribute and model are set.');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
            'options'   => [
                'todayBtn' => false,
            ],
        ]);
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

    //<editor-fold Desc="Columns">
    public function testColumns()
    {
        $this->writeHeader('Testing Columns');
        $dataProvider = new ArrayDataProvider(['allModels' => $this->buildGridData()]);
        echo GridView::widget([
            'id'             => 'normal-test',
            'refreshOptions' => false,
            'dataProvider'   => $dataProvider,
            'columns'        => [
                [
                    'attribute' => 'a',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
                [
                    'attribute' => 'b',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
                [
                    'class'          => 'KHanS\Utils\columns\ActionColumn',
                    'audit'          => true,
                    'dropdown'       => true,
                    'dropdownButton' => ['class' => 'btn btn-default alert-success', 'label' => 'GoOn'],
                    'header'         => 'Extra Action',
                    'visibleButtons' => [
                        'view'     => false,
                        'update'   => false,
                        'delete'   => false,
                        'download' => false,
                        'audit'    => false,
                    ],
                    'extraItems'     => $this->buildExtras(),
                ],
                [
                    'class'          => 'KHanS\Utils\columns\ActionColumn',
                    'audit'          => false,
                    'dropdown'       => true,
                    'download'       => Url::to(['/my-action', 'id' => 124]),
                    'dropdownButton' => ['class' => 'btn btn-danger'],
                ],
            ],
            'title'          => 'This is a Title',
            'footer'         => false,
            'rowOptions'     => function($model, $index, $widget, $grid) {
                if ($model['a'] == 'Three') {
                    return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
                }

                return [];
            },
        ]);
    }

    private function buildGridData()
    {
        return [
            [
                'a'          => 'One', 'b' => 1.1, 'c' => 'Eins', 'd' => 101, 'created_by' => 'کاربر یکم',
                'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            [
                'a'          => 'Two', 'b' => 2.2, 'c' => 'Zwei', 'd' => 202, 'created_by' => 'کاربر یکم',
                'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            [
                'a'          => 'Three', 'b' => 3.3, 'c' => 'Drei', 'd' => 303, 'created_by' => 'کاربر یکم',
                'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            [
                'a'          => 'Four', 'b' => 4.4, 'c' => 'Vier', 'd' => 404, 'created_by' => 'کاربر یکم',
                'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
        ];
    }
    //</editor-fold>

    //<editor-fold Desc="GridView">

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
            'reset'  => [],
        ];
    }

    public function testGridView()
    {
        $this->writeHeader('Normal GridView');
        $dataProvider = new ArrayDataProvider(['allModels' => $this->buildGridData()]);
        echo GridView::widget([
            'id'             => 'normal-test',
            'refreshOptions' => false,
            'dataProvider'   => $dataProvider,
            'columns'        => [
                [
                    'attribute' => 'a',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
                [
                    'attribute' => 'b',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
                [
                    'class' => 'KHanS\Utils\columns\ActionColumn',
                ],
            ],
            'title'          => 'This is a Title',
            'footer'         => false,
            'rowOptions'     => function($model, $index, $widget, $grid) {
                if ($model['a'] == 'Three') {
                    return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
                }

                return [];
            },
        ]);
    }

    public function testAjaxGridView()
    {
        $this->writeHeader('AJAX GridView');
        $dataProvider = new ArrayDataProvider(['allModels' => $this->buildGridData()]);
        echo AjaxGridView::widget([
            'id'           => 'pjax-test',
            'dataProvider' => $dataProvider,
            'columns'      => [
                [
                    'attribute' => 'c',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
                [
                    'attribute' => 'd',
                    'class'     => 'KHanS\Utils\columns\DataColumn',
                ],
            ],
            'title'        => false,
            'footer'       => 'This is a footer.',
            'rowOptions'   => function($model, $index, $widget, $grid) {
                if ($model['a'] == 'Three') {
                    return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
                }

                return [];
            },
        ]);
    }
    //</editor-fold>
}