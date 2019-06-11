<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;
use khans\utils\demos\data\SysEavAttributes;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowEvents */

if (!Yii::$app->request->isAjax) {
    $this->title = 'Test Workflow Events: ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
    $this->params['breadcrumbs'][] = ['label' => 'Test Workflow Events with EAV', 'url' => ['index']];
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

    foreach (SysEavAttributes::find()->where(['entity_table' => 'test_workflow_events'])->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
            $attributes[] = [
                'attribute' => $field->attr_name,
                'value'     => $model->getBooleanView($field->attr_name),
                'format'    => 'raw',
            ];
        } else {
            $attributes[] = [
                'attribute' => $field->attr_name,
            ];
        }
    }

?>
<div class="test-workflow-events-view">
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
