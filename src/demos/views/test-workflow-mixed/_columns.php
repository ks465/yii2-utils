<?php
use khans\utils\models\KHanModel;

use khans\utils\widgets\GridView;
use yii\helpers\Url;
use khans\utils\components\workflow\KHanWorkflowHelper;

$column = [
    'checkbox' => [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    'serial' => [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
//     'title'           => [
//         'class'          => '\khans\utils\columns\DataColumn',
//         'attribute'      => 'title',
//         'hAlign'         => GridView::ALIGN_RIGHT,
//         'vAlign'         => GridView::ALIGN_MIDDLE,
//         'headerOptions'  => ['style' => 'text-align: center;'],
//         'contentOptions' => ['class' => 'pars-wrap'],
//         'width'          => '150px',
//     ],
    'workflow_status' => [
        'class'            => '\khans\utils\columns\ProgressColumn',
        'attribute'        => 'workflow_status',
        'label'            => 'Workflow Label',
        'mixedDefinitions' => true,
        'width'            => '100px',
    ],
    'status' => [
        'class'       => '\khans\utils\columns\DataColumn',
        'attribute'   => 'workflow_status',
        'label'       =>'Workflow ID',
        'width'       => '100px',
        'filter'      => false,
        'mergeHeader' => true,
    ],
    'actor' => [
        'class'       => '\khans\utils\columns\DataColumn',
        'attribute'   => 'actor',
        'value'       => function($model) {
            return $model->actor . ' <small class=text-danger">(' . (Yii::$app->user->can('see')? 'Yes' : 'No') . ')</small>';
        },
        'label'       => 'Actor Role for Current Record-State',
        'width'       => '100px',
        'format'      => 'html',
        'mergeHeader' => true,
    ],
//     'workflow'        => [
//         'value'          => function($model) {
//         if(false === $model->shouldSendEmail()){
//             return 'FALSE';
//         }

//         return KHanWorkflowHelper::getEmailTemplate($model->getWorkflowStatus());
//         },
//         'label'          => 'eMail',
//         'mergeHeader'    => true,
//         'hAlign'         => GridView::ALIGN_LEFT,
//         'vAlign'         => GridView::ALIGN_MIDDLE,
//         'headerOptions'  => ['style' => 'text-align: center;'],
//         'contentOptions' => ['class' => 'pars-wrap'],
//         'width'          => '100px',
//     ],
];


$column['action'] =[
        'class'     => '\khans\utils\columns\ActionColumn',
        'runAsAjax' => true,
        'audit'     => true,
    ];

return $column;
