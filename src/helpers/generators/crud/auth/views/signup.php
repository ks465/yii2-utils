<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 13/12/18
 * Time: 17:30
 */

/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";
?>
/** @noinspection PhpUnhandledExceptionInspection */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use khans\utils\widgets\Captcha;

/* @var $this yii\web\View */
/* @var $model <?= $generator->authForms ?>\SignupForm */

$this->title = 'نام‌نویسی';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= "<?= " ?>Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= "<?php " ?>$form = ActiveForm::begin([
                    'id' => 'signup-form',
                ]); ?>

                <?= "<?= " ?>$form->field($model, 'name', ['inputOptions' => ['autocomplete' => 'off']]) ?>
                <?= "<?= " ?>$form->field($model, 'family', ['inputOptions' => ['autocomplete' => 'off']]) ?>
                <?= "<?= " ?>$form->field($model, 'email', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['class' => 'ltr']) ?>

                <?= "<?= " ?>$form->field($model, 'password')->passwordInput() ?>
                <?= "<?= " ?>$form->field($model, 'password_repeat')->passwordInput() ?>

				<?=  "<?= " ?>Captcha::widget([
                    'model'     => $model,
                    'form'      => $form,
                    'attribute' => 'verifyCode',
                ]) ?>

                <?= "<?= " ?>Html::submitButton('ثبت نام', ['class' => 'btn btn-success btn-block']) ?>

                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= "<?= " ?>Html::a('پیش از این نام‌نویسی نموده‌اید؟ وارد شوید!', ['login']) ?>
        </p>
    </div>
</div>
