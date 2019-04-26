<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavAttributesSearch */
/* @var $form kartik\form\ActiveForm */
?>

<div class="sys-eav-attributes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'entity_table') ?>

    <?= $form->field($model, 'attr_name') ?>

    <?= $form->field($model, 'attr_label') ?>

    <?= $form->field($model, 'attr_type') ?>

    <?php // echo $form->field($model, 'attr_length') ?>

    <?php // echo $form->field($model, 'attr_scenario') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('بگرد', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('پاک‌کن', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
