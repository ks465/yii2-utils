<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysUsers */
/* @var $form kartik\form\ActiveForm */
?>
<div class="sys-users-reset">
    <div class="sys-users-form">

        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'formConfig' => ['labelSpan' => 3]]); ?>

        <?= $form->field($model, 'username')->staticInput() ?>

        <?= $form->field($model, 'email')->staticInput() ?>

        <?= $form->field($model, 'password_hash')->passwordInput() ?>

        <?= $form->field($model, 'access_token')->textArea(['rows' => 3])
            ->hint('خالی گذاشتن این جعبه توکن دسترسی را پاک می‌کند. هر مقدار دیگر توکن ایمن تازه خواهد ساخت.') ?>


        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>
    <?= $this->render('_stats', [
        'model' => $model,
    ]) ?>
</div>
