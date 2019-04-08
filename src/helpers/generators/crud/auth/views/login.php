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

use kartik\checkbox\CheckboxX;
use khans\utils\widgets\Captcha;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= $generator->authForms ?>\LoginForm */
/* @var $withEmail boolean */

$this->title = 'ورود به سامانه';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-login-heading">
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
</div>

<div class="login-form col-md-offset-1 col-md-5">
    <?= "<?php " ?>$form = ActiveForm::begin([
        'id'          => 'login-form',
        'options'     => ['class' => ActiveForm::TYPE_HORIZONTAL],
        'fieldConfig' => ['autoPlaceholder' => true,],
    ]); ?>
    <?= "<?= " ?>$form->field($model, 'username', [
        'options' => [
            'class' => 'form-group ltr text-right',
            'style' => 'direction: ltr;',
        ],
        'addon'   => [
            'groupOptions' => ['class' => 'input-group-lg'],
            'prepend'      => ['content' => '<i class="glyphicon glyphicon-user"></i>'],
            'append'       => $withEmail ? [
                'content' => '@aut.ac.ir', 'options' => ['style' => 'font-family: Monaco, monospace;'],
            ] : [],
        ],
    ])
        ->textInput(['autofocus' => true, 'tabindex' => 1,]);
    ?>

    <?= "<?= " ?>$form->field($model, 'password', [
        'options' => [
            'class' => 'form-group ltr text-right',
            'style' => 'direction: ltr;',
        ],
        'addon'   => [
            'groupOptions' => ['class' => 'input-group-lg'],
            'prepend'      => ['content' => '<i class="glyphicon glyphicon-lock"></i>'],
        ],
    ])
        ->passwordInput(['tabindex' => 2]) ?>

    <div class="form-group">
        <?="<?php " ?>if ($model->scenario == 'withCaptcha'): ?>
            <?= "<?= " ?>Captcha::widget([
                'model'     => $model,
                'form'      => $form,
                'attribute' => 'verifyCode',
            ]) ?>
        <?="<?php " ?>endif; ?>
    </div>

    <?="<?php " ?>if (Yii::$app->user->enableSession): ?>
        <div class="form-group">
            <?= "<?= " ?>$form->field($model, 'rememberMe', [
                'template'     => '{input}{label}{error}{hint}',
            ])->widget(CheckboxX::class, [
                    'autoLabel' => true,
                    'pluginOptions' => [
                        'threeState' => false,
                    ],
            ]) ?>
        </div>
    <?="<?php " ?>endif; ?>

    <div class="form-group text-center">
        <?= "<?= " ?>Html::submitButton('ورود', [
            'class'    => 'btn btn-primary btn-lg btn-block',
            'name'     => 'login-button',
            'tabindex' => 1000,
        ]) ?>
    </div>
    <?= "<?php " ?>ActiveForm::end(); ?>

    <div class="text-muted">
        اگر گذرواژه خود را فراموش نموده‌اید،
        <?= "<?= " ?>Html::a('بازیابی نمایید.', ['request-password-reset',]) ?>.
    </div>
</div>

<div class="col-md-offset-1 col-md-4">
    <p class="alert alert-info text-justify h4">
        <i class="glyphicon glyphicon-exclamation-sign"> </i>
        توجه داشته باشید، گذرواژه ورود به این سامانه جدا از گذرواژه سامانه ایمیل دانشگاه است.
    </p>
    <p class="alert alert-warning text-justify h4">
        <i class="glyphicon glyphicon-question-sign"> </i>
        اگر برای اولین بار به این سامانه وارد می‌شوید، لازم است
        <?= "<?= " ?> Html::a('گذرواژه خود را بازیابی نمایید',
            [
                'request-password-reset',
            ]) ?>
        .
    </p>
</div>
