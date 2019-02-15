<?php

use khans\utils\components\ArrayHelper;
use khans\utils\components\StringHelper; ?>
    <div class="khan-default-index">
        <h1><?= $this->context->action->uniqueId ?></h1>
        <p>
            This is the view content for action "<?= $this->context->action->id ?>".
            The action belongs to the controller "<?= get_class($this->context) ?>"
            in the "<?= $this->context->module->id ?>" module.
        </p>
        <p>
            You may customize this page by editing the following file:<br>
            <code><?= __FILE__ ?></code>
        </p>
    </div>
<?php

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


