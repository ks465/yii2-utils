<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use kartik\detail\DetailView;
use \khans\utils\widgets\GridView;
use \khans\utils\components\Jalali;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'labelColOptions' => ['style' => 'width: 30%'],
        'attributes' => [
            'id',
            'name',
            'family',
            [
                'attribute' => 'email',
                'value'     => '<div class="ltr" style="font-family: Helvetica;">' . $model->email . '</div>',
                'format'    => 'raw',
            ],
            'username',
            [
               'attribute' => 'auth_key',
                'value'     => empty($model->auth_key) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE,
                'format'    => 'html',
            ],
            [
                'attribute' => 'password_hash',
                'value'     => empty($model->password_hash) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE,
                'format'    => 'html',
            ],
            [
                'attribute' => 'password_reset_token',
                'value'     => empty($model->password_reset_token) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE,
                'format'    => 'html',
            ],
            [
                'attribute' => 'access_token',
                'value'     => empty($model->access_token) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE,
                'format'    => 'html',
            ],
            [
                'attribute' => 'status',
                'value'     => $model->getStatus(),
            ],
            [
                'attribute' => 'last_visit_time',
                'value'     => ($model->last_visit_time == 0) ? GridView::ICON_INACTIVE : Jalali::date(Jalali::KHAN_LONG, $model->last_visit_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'create_time',
                'value'     => Jalali::date(Jalali::KHAN_LONG, $model->create_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'update_time',
                'value'     => Jalali::date(Jalali::KHAN_LONG, $model->update_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'delete_time',
                'value'     => ($model->delete_time == 0) ? GridView::ICON_INACTIVE : Jalali::date(Jalali::KHAN_LONG, $model->delete_time),
                'format'    => 'html',
            ],
        ],
    ]) ?>

</div>
