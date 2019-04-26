<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcParentsSearch */
/* @var $form kartik\form\ActiveForm */
?>

<div class="pc-parents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oci_table') ?>

    <?= $form->field($model, 'maria_table') ?>

    <?= $form->field($model, 'maria_pk') ?>

    <?= $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'is_applied')->checkbox() ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('بگرد', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('پاک‌کن', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
