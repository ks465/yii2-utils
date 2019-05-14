<?php
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\TestWorkflowEavSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Workflow Events with EAV';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="test-workflow-events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'                 => 'test-workflow-events-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__.'/_columns.php'),
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
