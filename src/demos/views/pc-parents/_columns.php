<?php
use khans\utils\models\KHanModel;

use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
    'checkbox' => [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    'serial' => [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // 'id' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'id',
    // ],
    'oci_table' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'oci_table',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'maria_table' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'maria_table',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'maria_pk' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'maria_pk',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'comment' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'comment',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'order' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'order',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'status' => [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanModel::getStatuses(),
    ],
    // 'created_at' => [
        // 'class'     => '\khans\utils\columns\JalaliColumn',
        // 'attribute' => 'created_at',
    // ],
    // 'updated_at' => [
        // 'class'     => '\khans\utils\columns\JalaliColumn',
        // 'attribute' => 'updated_at',
    // ],
    // 'created_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'created_by',
        // 'value'     => function($model) { return $model->getCreator()->fullName; },
    // ],
    // 'is_applied' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'is_applied',
    // ],
    // 'updated_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'updated_by',
        // 'value'     => function($model) { return $model->getUpdater()->fullName; },
    // ],
];


$column['action'] =[
        'class'      => '\khans\utils\columns\ActionColumn',
        'runAsAjax'  => false,
    ];

return $column;
