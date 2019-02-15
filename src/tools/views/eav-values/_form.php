<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use khans\utils\components\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavValues */

?>

<div class="sys-eav-values-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attribute_id')->widget(Select2::class, [
        'theme'         => Select2::THEME_BOOTSTRAP,
        'initValueText' => ArrayHelper::getValue(\khans\utils\tools\models\SysEavValues::find()->getTitle('entity_table')->where(['sys_eav_values.id' => $model->attribute_id])->one(), 'entity_table'),
        'hideSearch'    => false,
        'pluginOptions' => [
            'allowClear'         => false,
            'dir'                => 'rtl',
            'minimumInputLength' => 3,
            'ajax'               => [
                'url'      => Url::to(['parents']),
                'dataType' => 'json',
                'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'record_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioButtonGroup(khans\utils\models\KHanModel::getStatuses()) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'بنویس' : 'بنویس', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
