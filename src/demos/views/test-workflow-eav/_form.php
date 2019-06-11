<?php

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use khans\utils\demos\data\SysEavAttributes;
/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowEvents */
?>

<div class="test-workflow-events-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'workflow_status')->widget(\khans\utils\components\workflow\WorkflowField::class, []) ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>


    <?php foreach (SysEavAttributes::find()->where(['entity_table' => 'test_workflow_events'])->all() as $field) {
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
