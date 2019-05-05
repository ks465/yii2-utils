<?php

use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */

$onClick = "
$('#modalHelp').modal('show');
$.ajax({
    type: 'POST',
    cache: false,
    url: '" . Url::to([
        'help',
        'module'     => $this->context->module->id,
        'controller' => $this->context->id,
        'action'     => $this->context->action->id,
    ]) . "',
    success: function(response) {
        $('#modalHelp .modal-body').html(response);
    },
});
return false;
";

?>
    <div class="row">
        <div class="col-md-6 ltr">
            <p>Add Following to config in order to be able to use test data:</p>
            <pre>
'test' => [
    'class'   => 'yii\db\Connection',
    'dsn'     => 'sqlite:@khan/demos/data/test-data.db',
    'charset' => 'utf8',
],
</pre>
        </div>
        <div class="col-md-6">
            <p>Total Online Usres: <?= who() ?></p>
            <p class="row">
                <span class="col-md-4">
                    <a class="btn btn-success btn-block" href="/khans/vendor/khans465/yii2-utils/docs/index.html"
                       target="_blank">API</a>
                </span>
                <span class="col-md-4">
                    <a class="btn btn-success btn-block" href="/khans/vendor/khans465/yii2-utils/docs/g_README.html"
                       target="_blank">Guide</a>
                </span>
                <span class="col-md-4">
                    <a class="btn btn-info btn-block" onclick="<?= $onClick ?>" href="#">Help</a>
                </span>
            </p>
            <p class="row">
                <span class="col-md-4">
                    <a class="btn btn-primary btn-block" href="<?= Url::to(['reset-table']) ?>">Reset Test Table</a>
                </span>
                <span class="col-md-4">
            <a class="btn btn-primary btn-block" href="<?= Url::to(['reset-eav']) ?>">Reset EAV Data</a>
        </span>
                <span class="col-md-4">
            <a class="btn btn-primary btn-block" href="<?= Url::to(['reset-workflow']) ?>">Reset Workflow Data</a>
        </span>
            </p>
        </div>
    </div>
    <!--Help Modal Page-->
<?php
Modal::begin([
    'size'        => Modal::SIZE_LARGE,
    'closeButton' => ['label' => 'ببند', 'class' => 'btn btn-success pull-left'],
    'id'          => 'modalHelp',
    'header'      => '<h4><small>راهنما:</small> <mark>' . $this->title . '</mark></h4>',
    'footer'      => '<p>&nbsp;' .
        '<span class="pull-left">' . Yii::getVersion() . '</span>' .
        '</p>',
]);
Modal::end();
?>
    <!--System tools-->
<?= $this->render('tools') ?>
    <!--Grid Views-->
<?= $this->render('/grid-view/index') ?>
    <!--Components-->
<?= $this->render('/components/index') ?>

<?php
$this->title = 'List of Demo Pages';
$this->params['breadcrumbs'] = [$this->title];