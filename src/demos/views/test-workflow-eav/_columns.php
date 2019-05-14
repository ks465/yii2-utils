<?php
use khans\utils\models\KHanModel;
use khans\utils\demos\data\SysEavAttributes;
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
    'status' => [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanModel::getStatuses(),
    ],
];

    foreach (SysEavAttributes::find()->where(['entity_table' => 'test_workflow_events'])->active()->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
            $column[$field->attr_name] = [
                'class'     => '\khans\utils\columns\BooleanColumn',
                'attribute' => $field->attr_name,
            ];
        } elseif ($field->attr_type == SysEavAttributes::DATA_TYPE_NUMBER) {
            $column[$field->attr_name] = [
                'class'     => '\khans\utils\columns\ArithmeticColumn',
                'attribute' => $field->attr_name,
            ];
        } else {
            $column[$field->attr_name] = [
                'class'          => '\khans\utils\columns\DataColumn',
                'attribute'      => $field->attr_name,
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ];
        }
    }

$column['action'] =[
        'class'      => '\khans\utils\columns\ActionColumn',
        'runAsAjax'  => true,
    ];

return $column;
