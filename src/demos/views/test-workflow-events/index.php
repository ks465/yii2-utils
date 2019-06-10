<?php

use khans\utils\widgets\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\TestWorkflowEventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Workflow Events';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>
<p class="alert-info alert">
    If the transition needs sending emails, it would be written to `sys_history_email` table.
</p>
<div class="test-workflow-events-index col-md-6">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'test-workflow-events-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__ . '/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'itemLabelSingle'    => 'داده',
            'itemLabelPlural'    => 'داده‌ها',
            'createAction'       => [
                'ajax' => true,
            ],
        ]) ?>
    </div>
</div>
<pre class="col-md-6">
    <?php vd(\khans\utils\demos\workflow\WF::getDefinition()['status']) ?>
</pre>
