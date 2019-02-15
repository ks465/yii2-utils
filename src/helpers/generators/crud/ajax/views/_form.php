<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-971125
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

use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
<?= $generator->enableEAV? 'use khans\utils\tools\models\SysEavAttributes;':'' ?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
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

<?php if($generator->enableEAV): ?>
    <?= "<?php " ?>foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == 'boolean') {
            echo $form->field($model, $field->attr_name, [
                'template' => '{input} {label} {error} {hint}',
            ])->widget(CheckboxX::class, [
                'autoLabel'     => false,
                'pluginOptions' => [
                    'threeState' => false,
                ],
            ]);
        } else {
            echo $form->field($model, $field->attr_name)->textInput(['maxlength' => true]);
        }
    } ?>
<?php endif; ?>

    <?='<?php if (!Yii::$app->request->isAjax){ ?>'."\n"?>
	  	<div class="form-group">
	        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('بنویس') ?> : <?= $generator->generateString('بنویس') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?="<?php } ?>\n"?>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
