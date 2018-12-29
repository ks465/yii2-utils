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

/* @var $this yii\web\View */
/* @var $model <?= $generator->authForms ?>\SignupForm */

$this->title = 'ثبت نام';
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

                <?= "<?= " ?>$form->field($model, 'name') ?>
                <?= "<?= " ?>$form->field($model, 'family') ?>
                <?= "<?= " ?>$form->field($model, 'email')->textInput(['class' => 'ltr']) ?>

                <?= "<?= " ?>$form->field($model, 'password')->passwordInput() ?>
                <?= "<?= " ?>$form->field($model, 'password_repeat')->passwordInput() ?>

                <?= "<?= " ?>$form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::class,
                    ['options' => ['class' => 'form-control'],]) ?>

                <?= "<?= " ?>Html::submitButton('ثبت نام', ['class' => 'btn btn-success btn-block']) ?>

                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= "<?= " ?>Html::a('پیش از این ثبت نام نموده‌اید؟ وارد شوید!', ['login']) ?>
        </p>
    </div>
</div>
