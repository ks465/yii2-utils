<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;
use khans\utils\demos\data\SysEavAttributes;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\MultiFormatEav */

if (!Yii::$app->request->isAjax) {
    $this->title = 'EAV Sample Data: ' . $model->pk_column;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'EAV Sample Data', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'pk_column',
    'integer_column',
    'text_column:ntext',
    'real_column',
    'boolean_column',
    'timestamp_column:datetime',
    'progress_column:ntext',
    [
        'attribute' => 'status',
        'value' => $model->getStatus(),
    ],
    [
        'attribute' => 'created_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'created_by',
        'value' => $model->getCreator()->fullName,
    ],
    [
        'attribute' => 'updated_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
    [
        'attribute' => 'updated_by',
        'value' => $model->getUpdater()->fullName,
    ],
];

    foreach (SysEavAttributes::find()->where(['entity_table' => 'multi_format_data'])->all() as $field) {
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
<div class="multi-format-eav-view">
<?php if (!Yii::$app->request->isAjax): ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->pk_column], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('پاک‌کن', ['delete', 'id' => $model->pk_column], [
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
