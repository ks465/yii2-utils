<?php

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcParents */
?>

<div class="pc-parents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oci_table')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maria_table')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maria_pk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'is_applied', [
                'template'     => '{input} {label}{error}{hint}',
            ])->widget(CheckboxX::class, [
                'autoLabel' => false,
                'pluginOptions' => [
                    'threeState' => false,
                ],
            ]); ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>



    <div class="form-group">
        <?= Html::submitButton('بنویس', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
