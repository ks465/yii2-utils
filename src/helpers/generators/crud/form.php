<?php
/**
 *
 * @package KHanS\Utils
 * @version 0.2.2-971122
 * @since   1.0
 */

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'enableEAV')->checkbox();
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'authForms');

echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
