<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 28/12/18
 * Time: 13:14
 */

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";

use yii\helpers\Inflector;
use yii\helpers\StringHelper; ?>

use yii\helpers\Html;
use khans\utils\components\Jalali;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>
<hr/>
<div class="row small <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-statss">
        <div class="col-lg-6 ltr">
            <p>
                <label>Auth Key: </label>
                <?= "<?= " ?>strlen($model->auth_key) ?>
            </p>
            <p>
                <label>Password Hash: </label>
                <?= "<?= " ?>strlen($model->password_hash) ?>
            </p>
            <p>
                <label>Access Token: </label>
                <?= "<?= " ?>strlen($model->access_token) ?>
            </p>
            <p>
                <label>Password Reset Token: </label>
                <?= "<?= " ?>strlen($model->password_reset_token) ?>
            </p>
        </div>
        <div class="col-lg-6">
            <p>
                <label>آخرین ورود: </label>
                <?= "<?= " ?>Jalali::date(Jalali::KHAN_SHORT, $model->last_visit_time) ?>
            </p>
            <p>
                <label>آخرین ویرایش: </label>
                <?= "<?= " ?>Jalali::date(Jalali::KHAN_SHORT, $model->update_time) ?>
            </p>
            <p>
                <label>زمان ساخت: </label>
                <?= "<?= " ?>Jalali::date(Jalali::KHAN_SHORT, $model->create_time) ?>
            </p>
            <p>
                <label>زمان پاک شدن: </label>
                <?= "<?= " ?>Jalali::date(Jalali::KHAN_SHORT, $model->delete_time) ?>
            </p>
        </div>
    </div>
