<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
use yii\helpers\Url;

$this->title = 'Grid View Demo Pages';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>
    <a href="<?= Url::to(['/demos/grid-view']) ?>"><?= $this->title ?></a>
</h2>

<div class="panel panel-primary ltr">
    <div class="panel-heading">
        Grid Views
    </div>
    <div class="panel-body">
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/extra-header']) ?>"
           title="Adding First Row of Header">
            First Row of Header
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/bulk-action']) ?>"
           title="The Same actions in Action Column and Bulk Action Dropdown">
            Bulk Action
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/dropdown-action']) ?>"
           title="Dropdown Action Column and AJAX + Modal actions AND containing `extraItems`">
            Dropdown Actions + Extra Items
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/disabled-actions']) ?>"
           title="ActionColumn `disabled` and `visibleButtons` properties are checked">
            Disabled Actions and Visible Buttons <sup>*2</sup>
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/action-confirms']) ?>"
           title="Confirmation types in ActionColumn are checked">
            Confirm Actions before Request
        </a>

        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/search-model']) ?>"
           title="Search Options available through models and columns">
            Search Model <sup>*1</sup>
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/eav-sample']) ?>"
           title="EAV Pattern Example.">
            Model with EAV Data <sup>*1</sup>
        </a>

        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/export-true']) ?>"
           title="Export Button => true">
            Export Menu -- True
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/export-menu']) ?>"
           title="Export Button =>GridView::EXPORTER_MENU; ExportMenu is activated.">
            Export Menu -- Menu
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/grid-view/export-simple']) ?>"
           title="Export Button => GridView::EXPORTER_SIMPLE; default export menu of the GridView is used.">
            Export Menu -- Simple
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/entities-r']) ?>"
           title="This Controller does not include Update, Create, and Delete actions and pages. The generator is different from the normal CRUD generator.">
            Read-only Controller
        </a>
    </div>
    <div class="panel-footer">
        <p>Most of the actions demonstrate modal action. For reaching the stand alone page, Ctrl + click the
            actions.</p>
        <p><sup>*1</sup>
            <mark>Model with EAV Data</mark> in this group and <mark>Search Model</mark> in grid view demos are essentially the same table.
            The relative model in EAV data has settings for using the EAV pattern.
        </p>
        <p class="text-info"><sup>*2</sup> Action
            <mark>Reset</mark>
            in this view only has stand alone response
        </p>
    </div>
</div>

<div class="panel panel-success ltr">
    <div class="panel-heading">
        Workflow Playground
    </div>
    <div class="panel-body">
		<a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/default/workflow']) ?>"
           title="List of workflow defintions and details defined in the application.">
            Workflow Definitions
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/test-workflow-events']) ?>"
           title="This Controller is used to manipulate data status and workflow to check different aspects of workflow behavior.">
            Workflow Statuses and Emails
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/test-workflow-eav']) ?>"
           title="This Controller is used to play with workflow and EAV simultanously.">
            Workflow Statuses and EAV
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/test-workflow-mixed']) ?>"
           title="This Controller is used to play with mixed workflow.">
            Mixed Workflow Sources
        </a>
    </div>
    <div class="panel-footer">
        <p>Most of the actions demonstrate modal action. For reaching the stand alone page, Ctrl + click the
            actions.</p>
        <p><sup>*1</sup>
            <mark>Model with EAV Data</mark> in this group and <mark>Search Model</mark> in grid view demos are essentially the same table.
            The relative model in EAV data has settings for using the EAV pattern.
        </p>
        <p class="text-info"><sup>*2</sup> Action
            <mark>Reset</mark>
            in this view only has stand alone response
        </p>
    </div>
</div>