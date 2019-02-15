<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavAttributes */
?>

<div class="sys-eav-attributes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity_table')->widget(Select2::class, [
        'theme'         => Select2::THEME_BOOTSTRAP,
        'data'          => ['' => ''] + array_combine(\Yii::$app->db->getSchema()->getTableNames(), \Yii::$app->db->getSchema()->getTableNames()),
        'pluginOptions' => [
            'dir' => 'rtl',
        ],
    ]) ?>
    <?= $form->field($model, 'attr_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attr_label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attr_type')->widget(Select2::class, [
        'theme'         => Select2::THEME_BOOTSTRAP,
        'data'          => ['' => '', 'boolean' => 'Boolean', 'string' => 'String', 'integer' => 'Integer'],
        'pluginOptions' => [
            'dir' => 'rtl',
        ],
    ]) ?>

    <?= $form->field($model, 'attr_length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
