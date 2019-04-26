<?php

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavValues */
?>

<div class="sys-eav-values-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attribute_id')->widget(\kartik\select2\Select2::class, [
            'initValueText' => $model->getParentTitle(),
            'hideSearch'    => false,
            'pluginOptions' => [
                'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'), // make sure search element of Select2 is working in modal dialog
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

    <?= $form->field($model, 'record_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>



    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
