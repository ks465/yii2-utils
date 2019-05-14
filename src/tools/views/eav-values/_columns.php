<?php

use khans\utils\components\ArrayHelper;
use khans\utils\tools\models\SysEavValues;
use khans\utils\models\KHanModel;

use khans\utils\widgets\GridView;
use yii\helpers\Html;
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
    'attribute_id' => [
        'class'     => '\khans\utils\columns\RelatedColumn',
        'attribute' => 'attribute_id',
        'parentController'=>'/demos/eav-attributes',
    ],
    'record_id' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'record_id',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'value' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'value',
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
        'runAsAjax'  => true,
    ];

return $column;
