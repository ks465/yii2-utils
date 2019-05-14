<?php
/* @var $this yii\web\View */

/* @var $dataProvider \yii\data\ArrayDataProvider */

use yii\helpers\Url;

$this->title = 'System Tool Demo Pages';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>
    <a href="<?= Url::to(['/demos/grid-view']) ?>"><?= $this->title ?></a>
</h2>

<div class="panel panel-success ltr">
    <div class="panel-heading">
        System Tools
    </div>
    <div class="panel-body">
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/history-database']) ?>"
           title="History of changes in the records in all database tables.">
            Database History
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/history-users']) ?>"
           title="History of users' login.">
            Users' Login History
        </a>

        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/pc-parents']) ?>"
           title="Parent Controller in Parent Child Pattern (View Page Is the Main Obstacle).">
            Parent Child -- Parent
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/pc-children']) ?>"
           title="Child Controller in Parent Child Pattern.">
            Parent Child -- Child
        </a>

        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/eav-attributes']) ?>"
           title="List of defined EAV attributes for the application tables.">
            EAV Attributes
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/eav-values']) ?>"
           title="List os values set for individual records of data.">
            EAV Values
        </a>

        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/khan/import-csv', 'db' => 'test']) ?>"
           title="Use `test` for connection and `test_import_csv` for target table for test.">
            Import CSV into Database</a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['/demos/default/workflow']) ?>"
           title="List of workflow defintions and details defined in the application.">
            Workflow Definitions</a>
    </div>
    <div class="panel-footer">
    </div>
</div>