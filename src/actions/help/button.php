<?php

/**
 * If you want to use this button:
 * 
 * ```php
 * $this->render('@khan/actions/help/button', [
 *  'label' => 'Testing Help',
 *  'title' => 'صفحه راهنمای آزمایشی',
 *  'class' => 'btn btn-info btn-block',
 * ])
 * ```
 * 
 * But usually it is better idea to put the Javascript an Modal in a layout page
 * and add the link to the NavBar menu.
 */

/* @var $label string */
/* @var $class string */
/* @var $title string */

use yii\bootstrap\Modal;
use yii\helpers\Url;

if (!isset($title)) {
    $title = $this->title;
}
if (!isset($class)) {
    $class = 'btn btn-info';
}

$onClick = "
$('#modalHelp').modal('show');
$.ajax({
    type: 'POST',
    cache: false,
    url: '" . Url::to([
            'help',
            'action' => $this->context->action->id,
        ]) . "',
    success: function(response) {
        $('#modalHelp .modal-body').html(response);
    },
});
return false;
";
?>
<div class="block">
    <?php
    Modal::begin([
        'size'        => Modal::SIZE_LARGE,
        'closeButton' => ['label' => 'ببند', 'class' => 'btn btn-success pull-left'],
        'id'          => 'modalHelp',
        'header'      => '<h4><small>راهنما:</small> <mark>' . $title . '</mark></h4>',
        'footer'      => '<p>&nbsp;' .
        '<span class="pull-left">' . Yii::getVersion() . '</span>' .
        '</p>',
    ]);
    Modal::end();
    ?>
    <a class="<?= $class ?>" onclick="<?= $onClick ?>" href="#"><?= $label ?></a>
</div>
