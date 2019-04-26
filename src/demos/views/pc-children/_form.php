<?php

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcChildren */
?>

<div class="pc-children-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_id')->widget(\kartik\select2\Select2::class, [
            'initValueText' => $model->getParentTitle(),
            'hideSearch'    => false,
            'pluginOptions' => [
'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
                'allowClear'         => false,
                'dir'                => 'rtl',
                'minimumInputLength' => 3,
                'ajax'               => [
                    'url'      => Url::to(['parents-list']),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            ],
            ]); ?>

    <?= $form->field($model, 'oci_field')->textInput() ?>

    <?= $form->field($model, 'oci_type')->textInput() ?>

    <?= $form->field($model, 'oci_length')->textInput() ?>

    <?= $form->field($model, 'maria_field')->textInput() ?>

    <?= $form->field($model, 'maria_format')->textInput() ?>

    <?= $form->field($model, 'label')->textInput() ?>

    <?= $form->field($model, 'reference_table')->textInput() ?>

    <?= $form->field($model, 'reference_field')->textInput() ?>

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



    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
