<?php

use khans\utils\widgets\GridView;
use khans\utils\components\workflow\KHanWorkflowHelper;

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
            if(false === $model->shouldSendEmail()){
                return 'FALSE';
            }

            return KHanWorkflowHelper::getEmailTemplate($model->getWorkflowStatus());
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
