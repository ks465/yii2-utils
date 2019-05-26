<?php

use khans\utils\components\{ArrayHelper, StringHelper};
use yii\helpers\Url;
use yii\bootstrap\Modal;
use khans\utils\widgets\ConfirmButton;
use kartik\form\ActiveForm;

$this->title = 'Admin Tools';
$this->params['breadcrumbs'][] = $this->title;


$routesModel = new \mdm\admin\models\Route();

$routes = $routesModel->getRoutes();

$routes['admin'] = $routes['demos'] = [];
foreach ($routes['available'] as $item) {
    if (
            StringHelper::startsWith($item, '/admin/')
            || StringHelper::startsWith($item, '/khan/')
            || StringHelper::startsWith($item, '/debug/')
            || StringHelper::startsWith($item, '/gii/')
            || StringHelper::startsWith($item, '/system/')
    ) {
        $routes['admin'] += ArrayHelper::removeValue($routes['available'], $item);
    }

    if(StringHelper::startsWith($item, '/demos/')){
        $routes['demos'] += ArrayHelper::removeValue($routes['available'], $item);
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
                <a class="btn btn-info col-sm-3" href="<?= Url::to(['/khan/history-database']) ?>">Database History</a>
                <a class="btn btn-primary col-sm-3" href="<?= Url::to(['/khan/eav-attributes']) ?>">EAV Attributes</a>
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['/khan/eav-values']) ?>">EAV Values</a>
                <a class="btn btn-danger col-sm-3" href="<?= Url::to(['/khan/import-csv']) ?>">Import CSV into Database</a>
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['/khan/default/workflow']) ?>">Workflow Definitions</a>
            </p>
            <p class="row-no-gutters">Users Management</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['system/user-all']) ?>">Users CRUD</a>
                <a class="btn btn-success col-sm-3" target="_blank" href="<?= Url::to(['/admin']) ?>">MDMSoft Admin</a>
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['system/menu-all']) ?>">Users Menu</a>
                <a class="btn btn-info col-sm-3" href="<?= Url::to(['/khan/history-users']) ?>">Users' Login History</a>
                <span class="col-sm-3">&nbsp;</span>
            </p>
        </div>
        <div class="col-sm-3">
            <?php
            $form = ActiveForm::begin([
                'id'     => 'form-cache',
                'action' => Url::to(['/khan/default/reset-cache']),
            ]);

            echo ConfirmButton::widget([
                'type'           => ConfirmButton::TYPE_WARNING,
                'formID'         => $form->id,
                'sendAjax'       => true,
                'buttonLabel'    => 'Clear Cache',
                'buttonClass'    => 'btn btn-warning btn-block',
                'title'          => 'Clear all of the system data cache',
                'message'        => 'All of the cached elements will be deleted. Are you sure?',
                'btnOKLabel'     => 'Clear All Cached Data',
                'btnCancelLabel' => 'Keep Current Cache',
                'btnOKIcon'      => 'fire',
                'btnCancelIcon'  => 'time',
            ]);
            ActiveForm::end();
            ?>
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
<div class="row well-lg">
    <div class="col-md-12 col-sm-6">
        <span class="col-md-2">
            <a class="btn btn-success btn-block" href="/khans/vendor/khans465/yii2-utils/docs/index.html"
               target="_blank">API</a>
        </span>
        <span class="col-md-2">
            <a class="btn btn-success btn-block" href="/khans/vendor/khans465/yii2-utils/docs/g_README.html"
               target="_blank">Guide</a>
        </span>
        <span class="col-md-2">
            <a class="btn btn-default btn-block" target="_blank" href="<?= Url::to(['/demos']) ?>">Demo Pages</a>
        </span>
        <span class="col-md-2">
            <?= $this->render('@khan/actions/help/button', ['label' => 'Help', 'class' => 'btn btn-info btn-block']) ?>
        </span>
        <span class="col-md-2">
        	<a class="btn btn-default btn-block" target="_blank" href="http://github.com/ks465">GitHub Rep</a>
        </span>
        <span class="col-md-2">
        	<a class="btn btn-default btn-block" target="_blank" href="http://pgrad.aut.ac.ir/keyhan">KHanLog</a>
        </span>
    </div>
</div>
<div class="panel panel-info ltr">
    <div class="panel-heading">
        Demo Pages
    </div>
    <div class="panel-body">
        <div class="well-small">
            <p class="row-no-gutters">Helpers</p>
            <p class="row well-sm">
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['glyphs']) ?>">Glyph Icons</a>
                <a class="btn btn-default col-sm-3" href="<?= Url::to(['fa']) ?>">Fontawesome Icons</a>

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
        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['wizflow']) ?>">Wizard Demo</a>

        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/db-tables']) ?>">System Tables ?!?!</a>
        <a class="btn btn-default col-sm-3" target="_blank" href="<?= Url::to(['system/db-fields']) ?>">System Fields ?!?!</a>
    </div>
    <div class="panel-footer">
     <span class="text-warning">
        <i class="glyphicon glyphicon-question-sign"></i>

    </span>

    </div>
</div>
