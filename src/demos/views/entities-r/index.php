<?php
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\MultiFormatDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Read Only Data';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="test-readonly-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'                 => 'test-multi-format-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__.'/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'bulkAction'         => false,
            'createAction'       => false,
        ])?>
    </div>
</div>
