<?php
use khans\utils\models\KHanModel;

use khans\utils\tools\models\SysEavAttributes;
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
         'id' => [
         'class'     => '\khans\utils\columns\DataColumn',
         'attribute' => 'id',
             'width' => '50px',
     ],
    'entity_table' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'entity_table',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'attr_name' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_name',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'attr_label' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_label',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'attr_type' => [
        'class'          => '\khans\utils\columns\EnumColumn',
        'attribute'      => 'attr_type',
        'enum'      => SysEavAttributes::getDataTypes(),
//        'hAlign'         => GridView::ALIGN_RIGHT,
//        'vAlign'         => GridView::ALIGN_MIDDLE,
//        'headerOptions'  => ['style' => 'text-align: center;'],
//        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'attr_length' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_length',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    // 'attr_scenario' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'attr_scenario',
    // ],
    'status' => [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanModel::getStatuses(),
    ],
    // 'created_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'created_by',
        // 'value'     => function($model) { return $model->getCreator()->fullName; },
    // ],
    // 'updated_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'updated_by',
        // 'value'     => function($model) { return $model->getUpdater()->fullName; },
    // ],
    // 'created_at' => [
        // 'class'     => '\khans\utils\columns\JalaliColumn',
        // 'attribute' => 'created_at',
    // ],
    // 'updated_at' => [
        // 'class'     => '\khans\utils\columns\JalaliColumn',
        // 'attribute' => 'updated_at',
    // ],
];


$column['action'] =[
        'class'      => '\khans\utils\columns\ActionColumn',
        'runAsAjax'  => false,
    ];

return $column;
