<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
use khans\utils\models\KHanIdentity;
use khans\utils\widgets\GridView;
use yii\helpers\Url;
use <?= $generator->modelClass ?>;

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
        'enum'      => KHanIdentity::getStatuses(),
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
        'value'=>function(<?= $modelClass ?> $model){
            if($model->password_hash == '!'){
                return null;
            }

            return $model->password_hash;
        },
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
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
        'class'      => '\khans\utils\columns\ActionColumn',
        'runAsAjax'  => true,
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