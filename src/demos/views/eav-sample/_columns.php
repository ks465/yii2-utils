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
        'pk_column' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'pk_column',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'integer_column' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'integer_column',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'text_column' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'text_column',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'real_column' => [
        'class'          => '\khans\utils\columns\ArithmeticColumn',
        'attribute'      => 'real_column',
//        'hAlign'         => GridView::ALIGN_RIGHT,
//        'vAlign'         => GridView::ALIGN_MIDDLE,
//        'headerOptions'  => ['style' => 'text-align: center;'],
//        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'boolean_column' => [
        'class'          => '\khans\utils\columns\BooleanColumn',
        'attribute'      => 'boolean_column',
//        'hAlign'         => GridView::ALIGN_RIGHT,
//        'vAlign'         => GridView::ALIGN_MIDDLE,
//        'headerOptions'  => ['style' => 'text-align: center;'],
//        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    // 'timestamp_column' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'timestamp_column',
    // ],
    // 'progress_column' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'progress_column',
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
    // 'created_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'created_by',
        // 'value'     => function($model) { return $model->getCreator()->fullName; },
    // ],
    // 'updated_at' => [
        // 'class'     => '\khans\utils\columns\JalaliColumn',
        // 'attribute' => 'updated_at',
    // ],
    // 'updated_by' => [
        // 'class'     => '\khans\utils\columns\DataColumn',
        // 'attribute' => 'updated_by',
        // 'value'     => function($model) { return $model->getUpdater()->fullName; },
    // ],
];
    foreach (SysEavAttributes::find()->where(['entity_table' => 'multi_format_data'])->active()->all() as $field) {
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
