<?php

use khans\utils\widgets\GridView;

$column = [
    'id'              => [
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'id',
        'width'     => '50px',
    ],
    'title'           => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'title',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
        'width'          => '150px',
    ],
    'workflow_status' => [
        'class'     => '\khans\utils\columns\ProgressColumn',
        'attribute' => 'workflow_status',
        'width'     => '100px',
    ],
    'workflow'        => [
        'value'          => function($model) {
            $x = $model->shouldSendEmail();
            if ($x instanceof Closure) {
                return 'Closure:: ' . call_user_func($x, $model);
            } elseif (is_bool($x)) {
                return $x ? 'TRUE' : 'FALSE';
            }

            return $x;
        },
        'label'          => 'eMail',
        'mergeHeader'    => true,
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
        'width'          => '100px',
    ],
];

$column['action'] = [
    'class'     => '\khans\utils\columns\ActionColumn',
    'audit'     => true,
    'runAsAjax' => true,
];

return $column;
