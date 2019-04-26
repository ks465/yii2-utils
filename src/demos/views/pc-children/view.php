<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcChildren */

if (!Yii::$app->request->isAjax) {
    $this->title = 'List of data having parent record: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'List of data having parent record', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'id',
    [
        'attribute' => 'table_id',
        'value' => $model->getParentTitle() . Html::a(' <i class="glyphicon glyphicon-link"></i>',
               ['pc-parents' . '/view'] +
               array_combine($model->parent::primaryKey(), khans\utils\components\ArrayHelper::filter($model->attributes, $model->getLinkFields())
        )),
        'format'=>'html',
    ],
    'oci_field',
    'oci_type',
    'oci_length',
    'maria_field',
    'maria_format',
    'label',
    'reference_table',
    'reference_field',
    'order',
    [
        'attribute' => 'status',
        'value' => $model->getStatus(),
    ],
    [
        'attribute' => 'created_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->created_at),
    ],
    [
        'attribute' => 'updated_at',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->updated_at),
    ],
    [
        'attribute' => 'created_by',
        'value' => $model->getCreator()->fullName,
    ],
    'is_applied:boolean',
    [
        'attribute' => 'updated_by',
        'value' => $model->getUpdater()->fullName,
    ],
];


?>
<div class="pc-children-view">
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
