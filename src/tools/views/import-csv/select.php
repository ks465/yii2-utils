<?php
/* @var $this yii\web\View */
/* @var $tablesAvailable array */
/* @var $id string */

/* @var $model \yii\base\DynamicModel */

use kartik\file\FileInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'بارگذاری فایل CSV در جدول داده‌ها';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ?></h1>
<h3>شناسه پایگاه داده انتخاب شده:: <?= $model->connection ?></h3>
<div id="import-csv-gather-data" class="col-md-6 col-md-offset-3">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->field($model, 'table')->widget(\kartik\select2\Select2::class, [
        'data'          => $tablesAvailable,
        'hideSearch'    => false,
        'pluginOptions' => [
            'allowClear' => false,
            'dir'        => 'rtl',
        ],
    ])->label('جدول هدف'); ?>

    <?= $form->field($model, 'file')->widget(FileInput::class, [
        'pluginOptions' => [
            'language'          => 'fa',
            'browseLabel'       => 'انتخاب فایل ...',
            'uploadAsync'       => false,
            'browseOnZoneClick' => true,
            'layoutTemplates'   => [
                'main1' =>
                    "<div class='input-group ltr {class}'>\n" .
                    "   <div class='input-group-btn'>\n" .
                    "       {browse}\n" .
                    "   </div>\n" .
                    "   {caption}\n" .
                    "</div>\n" .
                    "<div class='kv-upload-progress hide'></div>\n" .
                    "{preview}",
            ],
        ],
    ])->label('فایل CSV') ?>

    <div class="col-sm-6">
        <?= $form->field($model, 'enclosed')->textInput(['placeHolder' => 'پیش‌فرض "'])->label('جدا کننده متن') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'delimiter')->textInput(['placeHolder' => 'پیش‌فرض ,'])->label('جدا کننده فیلدها') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('ادامه ...', ['class' => 'btn btn-primary pull-right']) ?>
        <a class="btn btn-default col-md-3" title="انتخاب پایگاه داده"
           href="<?= Url::to(['index', 'db' => $model->connection]) ?>">برگرد</a>
    </div>

    <?php ActiveForm::end(); ?>
</div>