<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavAttributes */

if (!Yii::$app->request->isAjax) {
    $this->title = 'EAV Attributes Table: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => 'EAV Attributes Table', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'id',
    'entity_table',
    'attr_name',
    'attr_label',
    'attr_type',
    'attr_length',
    'attr_scenario',
    [
        'attribute' => 'status',
        'value'     => $model->getStatus(),
    ],
    [
        'attribute' => 'created_by',
        'value'     => $model->getCreator()->fullName,
    ],
    [
        'attribute' => 'updated_by',
        'value'     => $model->getUpdater()->fullName,
    ],
    [
        'attribute' => 'created_at',
        'value'     => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'updated_at',
        'value'     => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
];


?>
<div class="sys-eav-attributes-view">
    <?php if (!Yii::$app->request->isAjax): ?>
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('پاک‌کن', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'آیا از پاک کردن این رکورد اطمینان دارید؟',
                    'method'  => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => $attributes,
    ]) ?>
</div>
