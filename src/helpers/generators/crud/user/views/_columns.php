<?php
/**
 * This is the template for generating a User CRUD index columns file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-980130
 * @since   1.0
 */
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
    'checkbox' => [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    'serial' => [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    'id' => [
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'id',
        'width'     => '50px',
        'hAlign'    => GridView::ALIGN_CENTER,
        'vAlign'    => GridView::ALIGN_MIDDLE,
    ],
    'name' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'name',
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'family' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'family',
        'width'          => '200px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'email' => [
        'class'         => '\khans\utils\columns\DataColumn',
        'attribute'     => 'email',
        'width'         => '150px',
        'hAlign'        => GridView::ALIGN_LEFT,
        'vAlign'        => GridView::ALIGN_MIDDLE,
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
    'username' => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'username',
        'width'          => '150px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'status' => [
        'class'     => '\khans\utils\columns\EnumColumn',
        'attribute' => 'status',
        'enum'      => KHanIdentity::getStatuses(),
        'width'     => '100px',
    ],
    'auth_key' => [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'auth_key',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    'password_hash' => [
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
    'password_reset_token' => [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'password_reset_token',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    'access_token' => [
        'class'       => '\khans\utils\columns\BooleanColumn',
        'attribute'   => 'access_token',
        'trueLabel'   => 'دارد',
        'falseLabel'  => 'ندارد',
        'width'       => '50px',
        'mergeHeader' => true,
    ],
    'last_visit_time' => [
        'class'       => '\khans\utils\columns\JalaliColumn',
        'attribute'   => 'last_visit_time',
        'mergeHeader' => true,
    ],
    //'create_time' => [
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'create_time',
    //],
    //'update_time' => [
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'update_time',
    //],
    //'delete_time' => [
        //'class'     => '\khans\utils\columns\JalaliColumn',
        //'attribute' => 'delete_time',
    //],
    'action' => [
        'class'          => '\khans\utils\columns\ActionColumn',
        'runAsAjax'      => true,
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
