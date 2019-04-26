<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavAttributes */

$tablesList = Yii::$app->get('test')->getSchema()->getTableNames();
$x = Yii::$app->db->getSchema();

?>

<div class="sys-eav-attributes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity_table')->widget(Select2::class, [
        'theme'         => Select2::THEME_BOOTSTRAP,
        'data'          => ['' => ''] + array_combine($tablesList, $tablesList),
        'pluginOptions' => [
            'dir' => 'ltr',
        ],
    ]) ?>
    <?= $form->field($model, 'attr_name')->textInput(['class'=>'ltr']) ?>

    <?= $form->field($model, 'attr_label')->textInput() ?>

    <?= $form->field($model, 'attr_type')->widget(Select2::class, [
        'theme'         => Select2::THEME_BOOTSTRAP,
        'data'          => ['' => ''] + \khans\utils\demos\data\SysEavAttributes::getDataTypes(),
        'pluginOptions' => [
            'dir' => 'rtl',
        ],
    ]) ?>
    <?= $form->field($model, 'attr_length')->textInput() ?>

    <?= $form->field($model, 'attr_scenario')->textInput() ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>


    <div class="form-group">
        <?= Html::submitButton('بنویس', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
