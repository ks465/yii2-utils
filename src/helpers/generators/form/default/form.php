<?php
/**
 * This is the template for generating an action view file.
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form ActiveForm */
<?= "?>" ?>

<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

    <?php foreach ($generator->getModelAttributes() as $attribute): ?>
    <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
    <?php endforeach; ?>

        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Submit') ?>, ['class' => 'btn btn-primary']) ?>
        </div>
    <?= "<?php " ?>ActiveForm::end(); ?>

</div><!-- <?= str_replace('/', '-', trim($generator->viewName, '-')) ?> -->
