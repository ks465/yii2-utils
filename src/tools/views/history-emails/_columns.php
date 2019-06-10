<?php
use khans\utils\models\KHanModel;

use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
    'serial' => [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    'responsible_model' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'responsible_model',
        'width'          => '150px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'responsible_record' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'responsible_record',
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'workflow_start' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'workflow_start',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'workflow_end' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'workflow_end',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'workflow_transition' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'workflow_transition',
        'width'          => '200px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'user_id' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'user_id',
        'width'          => '150px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'enqueue_timestamp' => [
        'class'     => '\khans\utils\columns\JalaliColumn',
        'attribute' => 'enqueue_timestamp',
        'width'     => '150px',
    ],
];


$column['action'] =[
    'class'          => '\khans\utils\columns\ActionColumn',
    'runAsAjax'      => true,
    'audit'          => false,
    'visibleButtons' => [
        'delete' => false,
        'update' => false,
    ],
];

return $column;
