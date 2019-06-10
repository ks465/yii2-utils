<?php

/* @var $this yii\web\View */
/* @var $files array */
/* @var $selectedWF string */

use yii\web\JsExpression;
use kartik\form\ActiveForm;
use kartik\popover\PopoverX;
use kartik\select2\Select2;

if(!isset($selectedWF)){
    $selectedWF = '';
}

PopoverX::begin([
    'type'         => PopoverX::TYPE_DEFAULT,
    'placement'    => PopoverX::ALIGN_BOTTOM_LEFT,
    'size'         => PopoverX::SIZE_LARGE,
    'toggleButton' => [
        'label' => 'انتخاب فایل تعریف گردش کار' . ' <i class="glyphicon glyphicon-list-alt"></i>',
        'class' => 'btn btn-success pull-left',
    ],
    'header'       => '<i class="glyphicon glyphicon-list-alt"></i> ' . 'انتخاب گردش کار برای دیدن ادامه',
]);

$form = ActiveForm::begin([
            'fieldConfig' => ['showLabels' => false],
            'options'     => ['id' => 'workflow-form'],
        ]);
echo Select2::widget([
    'name'          => 'workflow_select',
    'data'          => ['' => ''] + $files,
    'value' => $selectedWF,
    'theme'         => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'escapeMarkup' => new JsExpression("function(m) { return m; }"),
        'dir'          => 'rtl',
    ],
    'pluginEvents'  => [
        "select2:select" => "function() {
            $('form#workflow-form').submit();
        }",
    ]
]);
ActiveForm::end();

PopoverX::end();
