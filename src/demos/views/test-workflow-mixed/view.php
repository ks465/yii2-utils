<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowMixed */

if (!Yii::$app->request->isAjax) {
    $this->title = 'Test Workflow Mixed: ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
    $this->params['breadcrumbs'][] = ['label' => 'Test Workflow Mixed', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'id',
    'title:ntext',
    [
        'attribute' => 'workflow_status',
        'value' => $model->getWorkflowState(),
        'format'=>'html'
    ],
    [
        'attribute' => 'status',
        'value' => $model->getStatus(),
    ],
    [
        'attribute' => 'created_by',
        'value' => $model->getCreator()->fullName,
    ],
    [
        'attribute' => 'created_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'updated_by',
        'value' => $model->getUpdater()->fullName,
    ],
    [
        'attribute' => 'updated_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
];


?>
<div class="test-workflow-mixed-view">
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
WorkflowButtons Sample:
<?= \khans\utils\components\workflow\WorkflowButtons::widget([
        'model' => $model,
       'name' => 'name-attribute-of the-button',
]) ?>

