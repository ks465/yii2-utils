<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavValues */

if (!Yii::$app->request->isAjax) {
    $this->title = 'List of EAV Values: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
    $this->params['breadcrumbs'][] = ['label' => 'List of EAV Values', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'id',
    [
        'attribute' => 'attribute_id',
        'value' => $model->getParentTitle() . Html::a(' <i class="glyphicon glyphicon-link"></i>',
               ['/demos/eav-attributes/view'] +
               array_combine($model->parent::primaryKey(), khans\utils\components\ArrayHelper::filter($model->attributes, $model->getLinkFields())
        )),
        'format'=>'html',
    ],
    'record_id',
    'value',
    [
        'attribute' => 'status',
        'value' => $model->getStatus(),
    ],
    [
        'attribute' => 'created_by',
        'value' => $model->getCreator()->fullName,
    ],
    [
        'attribute' => 'updated_by',
        'value' => $model->getUpdater()->fullName,
    ],
    [
        'attribute' => 'created_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'updated_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
];


?>
<div class="sys-eav-values-view">
<?php if (!Yii::$app->request->isAjax): ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('پاک‌کن', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => 'آیا از پاک کردن این رکورد اطمینان دارید؟',
        'method' => 'post',
        ],
        ]) ?>
    </p>
<?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>
