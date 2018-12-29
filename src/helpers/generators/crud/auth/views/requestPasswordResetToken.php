<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 13/12/18
 * Time: 17:29
 */

/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";
?>
/** @noinspection PhpUnhandledExceptionInspection */

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= $generator->authForms ?>\PasswordResetRequestForm */

$this->title = 'درخواست بازیابی گذرواژه فراموش شده';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="col-md-offset-5 col-md-6">
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

        <p>نشانی ایمیل خود را وارد نمایید. یک ایمیل حاوی راهنمای مراحل بعد برای شما ارسال خواهد شد.</p>
    </div>

    <div class="col-md-5 col-md-offset-1">
        <?= "<?php " ?>$form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= "<?= " ?>$form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= "<?= " ?>Html::submitButton('بفرست', ['class' => 'btn btn-primary pull-left']) ?>
        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>

    </div>
</div>
