<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:33
 */


namespace KHanS\Utils\tests\demos;


use KHanS\Utils\components\JalaliX;
use KHanS\Utils\widgets\AjaxGridView;
use KHanS\Utils\widgets\DatePicker;
use KHanS\Utils\widgets\GridView;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;

class TestWidgets extends BaseTester
{
    public function testDatePickerFull()
    {
        $this->writeHeader('Full date: YYYY/MM/DD');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => JalaliX::date('Y/m/d', time())]),
            'options'   => [
                'startDate' => '1345/01/01',
            ],
        ]);
    }

    public function testDatePickerMonth()
    {
        $this->writeHeader('Month view: YYYY/MM');

        echo DatePicker::widget([
            'attribute' => 'from_date',
            'model'     => new DynamicModel(['from_date' => JalaliX::date('Y/m', time())]),
            'options'   => [
                'startDate'   => '1345/01/01',
                'minViewMode' => 'months',
            ],
        ]);
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
                'a', 'b',
                [
                    'class'    => 'KHanS\Utils\columns\ActionColumn',
                    'audit'    => true,
                    'dropdown' => true,
                    'download' => 'xXx',
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
            ['a'          => 'One', 'b' => 1.1, 'c' => 'Eins', 'd' => 101, 'created_by' => 'کاربر یکم',
             'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            ['a'          => 'Two', 'b' => 2.2, 'c' => 'Zwei', 'd' => 202, 'created_by' => 'کاربر یکم',
             'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            ['a'          => 'Three', 'b' => 3.3, 'c' => 'Drei', 'd' => 303, 'created_by' => 'کاربر یکم',
             'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
            ['a'          => 'Four', 'b' => 4.4, 'c' => 'Vier', 'd' => 404, 'created_by' => 'کاربر یکم',
             'created_at' => 26465, 'updated_by' => 'کاربر دوم', 'updated_at' => 264650,
            ],
        ];
    }

    public function testAjaxGridView()
    {
        $this->writeHeader('AJAX GridView');
        $dataProvider = new ArrayDataProvider(['allModels' => $this->buildGridData()]);
        echo AjaxGridView::widget([
            'id'           => 'pjax-test',
            'dataProvider' => $dataProvider,
            'columns'      => [
                'c', 'd',
                [
                    'class'    => 'KHanS\Utils\columns\ActionColumn',
                    'audit'    => true,
                    'dropdown' => false,
                    'download' => 'xXx',
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
}