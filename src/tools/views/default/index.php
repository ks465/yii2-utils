<?php

use khans\utils\components\ArrayHelper;
use khans\utils\components\StringHelper;
use yii\helpers\Url;

?>
    <div class="btn-group">
        <button data-toggle="dropdown" class="dropdown-toggle btn btn-default" title="List of Tools">
            <i class="glyphicon glyphicon-cog"></i>&nbsp;
            Tools
            &nbsp;<b class="caret"></b>
        </button>
        <?= \khans\utils\widgets\DropdownX::widget([
            'items' => [
                '<li role="presentation" class="dropdown-header">KHanS Tools</li>',
                ['label' => 'RBAC Lists', 'url' => '#', 'title' => 'Extra Lists', 'class' => 'dropdown-toggle'],
//        [
//            'label' => 'System Tables', 'items' => [
//            ['label' => 'Setup', 'url' => '#'],
//            '<li class="divider"></li>',
//            ['label' => 'Tables', 'url' => '#'],
//            ['label' => 'Fields', 'url' => '#'],
//        ],
//        ],
                ['label' => 'Help Files', 'url' => '#'],
                ['label' => 'Loading ', 'url' => '#'],
                '<li class="divider"></li>',
                ['label' => 'Records History', 'url' => '/khan/history-database'],
                ['label' => 'Login History', 'url' => '/khan/history-users'],
                '<li class="divider"></li>',
                ['label' => 'EAV Attributes', 'url' => '/khan/eav-attributes'],
            ],
        ]);
        ?>
    </div>
<?php
$routesModel = new \mdm\admin\models\Route();

$routes = $routesModel->getRoutes();

$routes['admin'] = [];
foreach ($routes['available'] as $item) {
    if (
            StringHelper::startsWith($item, '/admin/')
            || StringHelper::startsWith($item, '/khan/')
            || StringHelper::startsWith($item, '/debug/')
            || StringHelper::startsWith($item, '/gii/')
    ) {
        $routes['admin'][] = ArrayHelper::removeValue($routes['available'], $item);
    }
}
vd($routes);


?>
<!--Tools-->
<div class="panel panel-primary ltr">
    <div class="panel-heading">
        Tools
    </div>
    <div class="panel-body">
        <div class="well-small">
            <p class="row-no-gutters">System Management</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['/gii']) ?>">GII</a>
                <a class="btn btn-success col-sm-3" target="_blank" href="<?= Url::to(['/khan/history-database']) ?>">Database History</a>
                <a class="btn btn-primary col-sm-3" target="_blank" href="<?= Url::to(['/khan/eav-attributes']) ?>">EAV Attributes</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['/khan/eav-values']) ?>">EAV Values</a>
            </p>
            <p class="row-no-gutters">Users Management</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/user-all']) ?>">Users CRUD</a>
                <a class="btn btn-success col-sm-3" target="_blank" href="<?= Url::to(['/admin']) ?>">MDMSoft Admin</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/menu-all']) ?>">Users Menu</a>
                <a class="btn btn-info col-sm-3" target="_blank" href="<?= Url::to(['/khan/history-users']) ?>">Users' Login History</a>
                <span class="col-sm-3">&nbsp;</span>
            </p>
        </div>
    </div>
    <div class="panel-footer">
    <span class="text-danger">
        <i class="glyphicon glyphicon-alert"></i>
        These are real tools working on main server data!
    </span>
    </div>
</div>
<!--Demos-->
<div class="panel panel-info ltr">
    <div class="panel-heading">
        Demo Pages
    </div>
    <div class="panel-body">
        <div class="well-small">
            <p class="row-no-gutters">Helpers</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['glyphs']) ?>">Glyph Icons</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['fa']) ?>">Fontawesome Icons</a>
                <a class="btn btn-success col-sm-3" target="_blank" href="<?= Url::to(['/demos']) ?>">Demo Pages</a>
            </p>
            <p class="row-no-gutters">Users Activities</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/signup']) ?>">Users SignUp</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/login']) ?>">Users Login</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/']) ?>">Users Token Login</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/logout']) ?>">Users Logout</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/password-reset-request']) ?>">Request Password Reset</a>
                <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/auth/reset-password', 'token' => '!']) ?>">Users Reset Password</a>
            </p>
            <p class="row-no-gutters">Widgets</p>
            <p class="row well-sm">
            </p>
        </div>
    </div>
    <div class="panel-footer">
     <span class="text-warning">
        <i class="glyphicon glyphicon-comment"></i>
        For these demos to work, add SQLite data source.
    </span>

    </div>
</div>
<!--Pendings-->
<div class="panel panel-default ltr">
    <div class="panel-heading">
        Pending Pages
    </div>
    <div class="panel-body">
        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['/workflow']) ?>">Workflow Manager</a>
        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['wizflow']) ?>">Wizard Demo</a>

        <a class="btn btn-default col-sm-3" target="_blank" href="<? //= \yii\helpers\Url::to(['csv']) ?>">KHanS CSV Importer</a>

        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/db-tables']) ?>">System Tables</a>
        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/db-fields']) ?>">System Fields</a>




    </div>
    <div class="panel-footer">
     <span class="text-warning">
        <i class="glyphicon glyphicon-question-sign"></i>
        
    </span>

    </div>
</div>
