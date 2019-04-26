<?php

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use khans\utils\demos\data\SysEavAttributes;
/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\MultiFormatEav */
?>

<div class="multi-format-eav-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'integer_column')->textInput() ?>

    <?= $form->field($model, 'text_column')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'real_column')->textInput() ?>

    <?= $form->field($model, 'boolean_column')->textInput() ?>

    <?= $form->field($model, 'timestamp_column')->textInput() ?>

    <?= $form->field($model, 'progress_column')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>


    <?php foreach (SysEavAttributes::find()->where(['entity_table' => 'multi_format_data'])->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
            echo $form->field($model, $field->attr_name, [
                'template' => '{input} {label} {error} {hint}',
            ])->widget(CheckboxX::class, [
                'autoLabel'     => false,
                'pluginOptions' => [
                    'threeState' => false,
                ],
            ]);
        } else {
            echo $form->field($model, $field->attr_name)->textInput(['maxlength' => true]);
        }
    } ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
