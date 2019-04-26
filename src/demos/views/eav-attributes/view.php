<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use khans\utils\components\Jalali;
use khans\utils\widgets\GridView;
/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavAttributes */

$this->title = 'List of EAV Attributes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'List of EAV Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$attributes = [
    'id',
    'entity_table',
    'attr_name',
    'attr_label',
    [
        'attribute' => 'attr_type',
        'value' => $model->getDataType(),
    ],
    'attr_length',
    'attr_scenario',
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
<div class="sys-eav-attributes-view">
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>

<?php
$searchModel = new \khans\utils\demos\data\SysEavValuesSearch([
   'query'=> $model->getChildren(),
]);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$columns = require(__DIR__ . '/../eav-values/_columns.php');
$columns['action']['controller'] = '/demos/eav-values';
unset($columns['attribute_id']);
?>
<div class="sys-eav-attributes-children-index">

    <h2>List of Child Data</h2>

    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'sys-eav-attributes-children-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => $columns,
            'export'             => true,
            'showRefreshButtons' => true,
            'itemLabelSingle'    => 'داده',
            'itemLabelPlural'    => 'داده‌ها',
            'bulkAction'         => [
                'action'  => 'bulk-delete',
                'label'   => 'پاک‌کن',
                'icon'    => 'trash',
                'class'   => 'btn btn-danger btn-xs',
                'message' => 'آیا اطمینان دارید همه را پا کنید؟',
            ],
            'createAction'       => [
                'ajax'    => true,
            ],
        ])?>
    </div>
</div>
