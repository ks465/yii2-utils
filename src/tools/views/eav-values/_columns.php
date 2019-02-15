<?php

use khans\utils\models\KHanModel;
use khans\utils\tools\models\SysEavValues;
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
    [
        'class'       => '\khans\utils\columns\RelatedColumn',
        'attribute'   => 'tableName',
        'label'       => 'Table Name',
        'targetModel' => '\khans\utils\tools\models\SysEavAttributes',
        'titleField'  => 'entity_table',
        'searchUrl'   => 'tables',
        'width'       => '100px',
        'hAlign'      => GridView::ALIGN_LEFT,
    ],
    [
        'class'       => '\khans\utils\columns\RelatedColumn',
        'attribute'   => 'attributeName',
        'label'       => 'Attribute Name',
        'value'       => function(SysEavValues $model) {
            return $model->parent->attr_label . ' (' . $model->parent->attr_name . ')';
        },
        'targetModel' => '\khans\utils\tools\models\SysEavAttributes',
        'titleField'  => 'attr_name',
        'width'       => '200px',
        'hAlign'      => GridView::ALIGN_RIGHT,
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'record_id',
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'value',
        'width'          => '300px',
        'hAlign'         => GridView::ALIGN_CENTER,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanModel::getStatuses(),
        'width'     => '100px',
    ],
];

$column[] = [
    'class'     => '\khans\utils\columns\ActionColumn',
    'runAsAjax' => true,
];

return $column;
