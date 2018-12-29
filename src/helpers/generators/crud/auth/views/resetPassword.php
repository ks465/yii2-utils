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
/* @var $model <?= $generator->authForms ?>\ResetPasswordForm */

$this->title = 'ویرایش گذرواژه';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="col-md-offset-5 col-md-6">
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

        <p>گذرواژه تازه مورد نظر خود را انتخاب کنید:</p>
    </div>

    <div class="col-md-5 col-md-offset-1">

            <?= "<?php " ?>$form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= "<?= " ?>$form->field($model, 'password')->passwordInput() ?>

            <?= "<?= " ?>$form->field($model, 'password_repeat')->passwordInput() ?>

            <div class="form-group">
                <?= "<?= " ?>Html::submitButton('بنویس', ['class' => 'btn btn-primary pull-left']) ?>
            </div>

            <?= "<?php " ?>ActiveForm::end(); ?>
        </div>
    </div>
</div>
