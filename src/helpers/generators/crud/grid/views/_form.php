<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
$safeAttributes = array_diff($safeAttributes, ['status', 'created_by', 'created_at', 'updated_by', 'updated_at']);

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;
use khans\utils\models\KHanModel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form kartik\form\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    <?= "<?= " ?>$form->field($model, 'status')->radioButtonGroup(KHanModel::getStatuses()) ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('بنویس') ?>, ['class' => 'btn btn-success']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
