<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\MultiFormatData */

if (!Yii::$app->request->isAjax) {
    $this->title = 'Read Only Data: ' . $model->pk_column;
    $this->params['breadcrumbs'][] = ['label' => 'Read Only Controller', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'pk_column',
    'integer_column',
    'text_column',
    'real_column',
    [
        'attribute' => 'boolean_column',
        'value'     => $model->boolean_column ? '<i class="glyphicon glyphicon-ok text-success"></i>' : '<i class="glyphicon glyphicon-remove text-danger"></i>',
        'format'=> 'html',
    ],
    'timestamp_column',
    [
        'attribute' => 'progress_column',
        'value'     => $model->getWorkflowState(),
    ],
    [
        'attribute' => 'created_by',
        'value'     => $model->getCreator()->fullName,
    ],
    [
        'attribute' => 'created_at',
        'value'     => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'updated_by',
        'value'     => $model->getUpdater()->fullName,
    ],
    [
        'attribute' => 'updated_at',
        'value'     => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
    [
        'attribute' => 'status',
        'value'     => $model->getStatus(),
    ],
];


?>
<div class="test-readonly-view">
    <?php if (!Yii::$app->request->isAjax): ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php endif; ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => $attributes,
    ]) ?>
</div>
