<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form kartik\form\ActiveForm */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-reset">
    <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

        <?= "<?php " ?>$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'formConfig' => ['labelSpan' => 3]]); ?>

        <?= "<?= " ?>$form->field($model, 'username')->staticInput() ?>

        <?= "<?= " ?>$form->field($model, 'email')->staticInput() ?>

        <?= "<?= " ?>$form->field($model, 'password_hash')->passwordInput() ?>

        <?= "<?= " ?>$form->field($model, 'access_token')->textArea() ?>


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
</div>
