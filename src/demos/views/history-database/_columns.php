<?php

use khans\utils\demos\data\SysHistoryDatabase;
use khans\utils\widgets\GridView;

$column = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'user_id',
        'value'          => function(SysHistoryDatabase $model) { return $model->getUser(); },
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
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
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'table',
        'width'          => '80px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'field_id',
        'width'          => '80px',
        'hAlign'         => GridView::ALIGN_LEFT,
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
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'new_value',
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
