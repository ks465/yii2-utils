<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use khans\utils\demos\data\SysUsers;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysUsers */
/* @var $form kartik\form\ActiveForm */
?>

<div class="sys-users-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= /*  $model->isNewRecord ?*/
        $form->field($model, 'username')->textInput(['maxlength' => true]) /*: */
        /*$form->field($model, 'username')->staticInput(['maxlength' => true])*/
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'family')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'ltr']) ?>


    <?= $form->field($model, 'status')->radioButtonGroup(SysUsers::getStatuses()) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
<?= $this->render('_stats', [
    'model' => $model,
]) ?>
