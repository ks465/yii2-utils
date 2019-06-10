<?php
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\TestWorkflowMixedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Workflow Mixed';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="alert-info alert ltr text-left">
<ul class="text-justify">
<li>
    If the transition needs sending emails, it would be written to `sys_history_email` table.
</li>
<li>
	Using mixed workflow prohibits selecting of `workflow status` by user upon creating a new record.
	It should be done in the code by defining the workflow ID and initial status at the same time based on designed strategy.
</li>
<li>
	After registering to a specific workflow, the record always belongs to that workflow.
	So changing states is possible only in that workflow.
</li>
<li>
	Labels of states in different definitions may be the same. In this case the state IDs are not the same, however.
	Hence filtering the columns and grid views could not be done in a generic form. It should be designed for each scenario.
</li>
</ul>
</div>
<div class="test-workflow-mixed-index col-md-7">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'                 => 'test-workflow-mixed-datatable-pjax',
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
<div class="col-md-5 ltr text-left">
	<h4>Various workflow definitions used in the example:</h4>
	<h3>WF:
		<span class="small"><?= \khans\utils\demos\workflow\WF::getDefinition()['metadata']['description'] ?></span>
	</h3>
    <?php vd(\khans\utils\demos\workflow\WF::getDefinition()['status']) ?>

	<h3>Multiple1WF:
		<span class="small"><?= \khans\utils\demos\workflow\Multiple1WF::getDefinition()['metadata']['description'] ?></span>
	</h3>
    <?php vd(\khans\utils\demos\workflow\Multiple1WF::getDefinition()['status']) ?>

	<h3>Multiple2WF:
		<span class="small"><?= \khans\utils\demos\workflow\Multiple2WF::getDefinition()['metadata']['description'] ?></span>
	</h3>
    <?php vd(\khans\utils\demos\workflow\Multiple2WF::getDefinition()['status']) ?>

	<h3>Multiple3WF:
		<span class="small"><?= \khans\utils\demos\workflow\Multiple3WF::getDefinition()['metadata']['description'] ?></span>
	</h3>
    <?php vd(\khans\utils\demos\workflow\Multiple3WF::getDefinition()['status']) ?>
</pre>
