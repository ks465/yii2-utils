<?php

use khans\utils\widgets\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\tools\models\search\\SysEavAttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'EAV Attributes Table';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-eav-attributes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'sys-eav-attributes-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__ . '/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'bulkAction'         => [
                'action'  => 'bulk-delete',
                'label'   => 'پاک‌کن',
                'icon'    => 'trash',
                'class'   => 'btn btn-danger btn-xs',
                'message' => 'آیا اطمینان دارید همه را پا کنید؟',
            ],
            'createAction'       => [
                'ajax' => true,
            ],
        ]) ?>
    </div>
</div>
