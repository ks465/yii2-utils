<?php

use kartik\select2\Select2;
use khans\utils\components\StringHelper;
use khans\utils\tools\models\SysHistoryDatabase;
use khans\utils\widgets\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

$column = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'               => '\khans\utils\columns\DataColumn',
        'attribute'           => 'user_id',
        'value'               => function(SysHistoryDatabase $model) { return $model->getUser(); },
        'filterType'          => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'hideSearch'    => false,
            'theme'         => Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear'         => true,
                'dir'                => 'rtl',
                'minimumInputLength' => 3,
                'ajax'               => [
                    'url'      => Url::to(['list-users']),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            ],
        ],
        'width'               => '100px',
        'hAlign'              => GridView::ALIGN_RIGHT,
        'vAlign'              => GridView::ALIGN_MIDDLE,
        'headerOptions'       => ['style' => 'text-align: center;'],
        'contentOptions'      => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'date',
        'width'          => '80px',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'               => '\khans\utils\columns\DataColumn',
        'attribute'           => 'table',
        'filterType'          => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'hideSearch'    => false,
            'theme'         => Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear'         => true,
                'dir'                => 'rtl',
                'minimumInputLength' => 3,
                'ajax'               => [
                    'url'      => Url::to(['table-schema']),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            ],
        ],
        'width'               => '80px',
        'hAlign'              => GridView::ALIGN_RIGHT,
        'vAlign'              => GridView::ALIGN_MIDDLE,
        'headerOptions'       => ['style' => 'text-align: center;'],
        'contentOptions'      => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'field_id',
        'width'          => '80px',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'field_name',
        'width'          => '80px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'old_value',
        'value'          => function(SysHistoryDatabase $model) {
            return StringHelper::truncate($model->old_value, 10);
        },
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'new_value',
        'value'          => function(SysHistoryDatabase $model) {
            return StringHelper::truncate($model->new_value, 10);
        },
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'type',
        'enum'      => SysHistoryDatabase::getEventTypes(),
        'width'     => '80px',
    ],
];

return $column;
