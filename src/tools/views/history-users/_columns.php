<?php

use khans\utils\widgets\GridView;

$column = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'username',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '250px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\JalaliColumn',
        'attribute' => 'date',
        'JFormat'   => \khans\utils\components\Jalali::KHAN_DATE,
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'time',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '100px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'result',
        'enum'      => \khans\utils\tools\models\SysHistoryUsers::getEventTypes(),
        'width'     => '100px',
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'attempts',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '50px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'ip',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '200px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'ltr'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'user_id',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '100px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'user_table',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'width'          => '150px',
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
];

return $column;
