<?php
use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use khans\utils\demos\data\TestWorkflowMixed;
use raoul2000\workflow\helpers\WorkflowHelper;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowMixed */

?>

<div class="test-workflow-mixed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'title') ?>

<?php if($model->isNewRecord): ?>
    <?=$form->field($model, 'workflow_status', ['options' => ['disabled' => true, 'readonly' => true]])
        ->hint('Using mixed workflow prohibits selecting of `workflow status` by user. It should be done in the code by defining the workflow ID and initial status at the same time.')?>
<?php else: ?>
    <?= $form->field($model, 'workflow_status')->widget(\khans\utils\widgets\WorkflowField::class, []) ?>
<?php endif; ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
