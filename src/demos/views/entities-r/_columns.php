<?php
use khans\utils\models\KHanModel;

use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
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
        'class'      => '\khans\utils\columns\ProgressColumn',
        'attribute'  => 'progress_column',
        'width'      => '100px',
    ],
];


$column[] =[
    'class'          => '\khans\utils\columns\ActionColumn',
    'runAsAjax'      => true,
    'audit'          => false,
    'visibleButtons' => [
        'delete' => false,
        'update' => false,
    ],
];

return $column;
