<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 27/01/19
 * Time: 19:51
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */


$this->title = $name;
?>
<div class="admin-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <div>
        <?php
        if (Yii::$app->user->isSuperAdmin) {
            if (function_exists('vd')) {
                vd($exception);
            } else {
                echo '<pre class="ltr">';
                var_dump($exception);
                echo '</pre>';
            }
        }
        ?>
    </div>

</div>
