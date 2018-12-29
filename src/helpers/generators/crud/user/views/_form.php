<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;
use khans\utils\models\KHanModel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form kartik\form\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'formConfig' => ['labelSpan' => 3]]); ?>

    <?= "<?= " ?> $model->isNewRecord ?
        $form->field($model, 'username')->textInput(['maxlength' => true]) :
        $form->field($model, 'username')->staticInput(['maxlength' => true])
    ?>

    <?= "<?= " ?>$form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= "<?= " ?>$form->field($model, 'family')->textInput(['maxlength' => true]) ?>

    <?= "<?= " ?>$form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'ltr']) ?>


    <?= "<?= " ?>$form->field($model, 'status')->radioButtonGroup(KHanModel::getStatuses()) ?>

    <?='<?php if (!Yii::$app->request->isAjax){ ?>'."\n"?>
	  	<div class="form-group">
	        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('بنویس') ?> : <?= $generator->generateString('بنویس') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?="<?php } ?>\n"?>

    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
<?= "<?= " ?>$this->render('_stats', [
    'model' => $model,
]) ?>
