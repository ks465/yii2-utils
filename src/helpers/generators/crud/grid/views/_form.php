<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971013
 * @since   1.0
 */
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
<?php if(in_array('status', $generator->getColumnNames())){
    echo "    <?= " . '$form->field($model, \'status\')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses())' . " ?>\n\n";
} ?>

    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('بنویس') ?>, ['class' => 'btn btn-success']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
