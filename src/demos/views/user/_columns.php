<?php
use khans\utils\widgets\GridView;
use yii\helpers\Url;
use khans\utils\demos\data\SysUsers;

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
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'id',
        'width'     => '50px',
        'hAlign'    => GridView::ALIGN_CENTER,
        'vAlign'    => GridView::ALIGN_MIDDLE,
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'name',
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'family',
        'width'          => '200px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'         => '\khans\utils\columns\DataColumn',
        'attribute'     => 'email',
        'width'         => '150px',
        'hAlign'        => GridView::ALIGN_LEFT,
        'vAlign'        => GridView::ALIGN_MIDDLE,
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
    [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'username',
        'width'          => '150px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => SysUsers::getStatuses(),
        'width'     => '100px',
    ],
    [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'auth_key',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'password_hash',
        'value'=>function(SysUsers $model){
            if($model->password_hash == '!'){
                return null;
            }

            return $model->password_hash;
        },
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '65px',
        'mergeHeader' => true,
    ],
    [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'password_reset_token',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'access_token',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    [
        'class'       => '\khans\utils\columns\JalaliColumn',
        'attribute'   => 'last_visit_time',
        'mergeHeader' => true,
        'width'       => '50px',
    ],
    //[
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'create_time',
    //],
    //[
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'update_time',
    //],
    //[
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'delete_time',
    //],
    [
        'class'          => '\khans\utils\columns\ActionColumn',
        'runAsAjax'      => true,
        'audit'          => true,
        'visibleButtons' => [
            'view'          => true,
            'update'        => function($model) { return $model->id > 0; },
            'delete'        => function($model) { return $model->id > 0; },
            'reset-pass'    => function($model) { return $model->id > 0; },
            'request-reset' => function($model) { return $model->id > 0; },
        ],
        'extraItems' => [
            'reset-pass' => [
                'icon'   => 'edit',
                'title'  => 'ویرایش کلیدها و گذرواژه',
                'config' => ['class' => 'text-danger'],
            ],
            'request-reset' => [
                'icon'   => 'send',
                'title'  => 'ایمیل بازیابی گذرواژه بفرست',
                'config' => ['class' => 'text-warning'],
            ],
        ],
    ],
];

return $column;
