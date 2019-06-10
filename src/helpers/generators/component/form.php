<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/01/19
 * Time: 09:24
 */
use khans\utils\helpers\generators\component\Generator;


/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator khans\utils\helpers\generators\model\Generator */

echo $form->field($generator, 'targetModel');
echo $form->field($generator, 'targetField');
echo $form->field($generator, 'titleField');
echo $form->field($generator, 'columnClass');
echo $form->field($generator, 'selectorPath');
echo $form->field($generator, 'actionClass');
echo $form->field($generator, 'widgetPath');

echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
