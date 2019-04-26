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
    'table_id' => [
        'class'     => '\khans\utils\columns\RelatedColumn',
        'attribute' => 'table_id',
        'parentController'=>'/demos/pc-parents',
    ],
    'oci_field' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'oci_field',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'oci_type' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'oci_type',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'oci_length' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'oci_length',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'maria_field' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'maria_field',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'maria_format' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'maria_format',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    // 'label' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'label',
    // ],
    // 'reference_table' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'reference_table',
    // ],
    // 'reference_field' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'reference_field',
    // ],
    // 'order' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'order',
    // ],
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
        'runAsAjax'  => true,
    ];

return $column;
