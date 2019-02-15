<?php

use khans\utils\models\KHanModel;
use khans\utils\widgets\GridView;

$column = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'     => '\khans\utils\columns\DataColumn',
    // 'attribute' => 'id',
    // ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'entity_table',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_name',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_label',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_type',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attr_length',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'attr_scenario',
    ],
    [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanModel::getStatuses(),
    ],
    // [
    // 'class'     => '\khans\utils\columns\DataColumn',
    // 'attribute' => 'created_by',
    // 'value'     => function($model) { return $model->getCreator()->fullName; },
    // ],
    // [
    // 'class'     => '\khans\utils\columns\DataColumn',
    // 'attribute' => 'updated_by',
    // 'value'     => function($model) { return $model->getUpdater()->fullName; },
    // ],
    // [
    // 'class'     => '\khans\utils\columns\JalaliColumn',
    // 'attribute' => 'created_at',
    // ],
    // [
    // 'class'     => '\khans\utils\columns\JalaliColumn',
    // 'attribute' => 'updated_at',
    // ],
];


$column[] = [
    'class'     => '\khans\utils\columns\ActionColumn',
    'runAsAjax' => true,
];

return $column;
