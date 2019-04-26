<?php
/**
 *
 * @package KHanS\Utils
 * @version 0.2.0-980123
 * @since   1.0
 */

use khans\utils\helpers\generators\model\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator khans\utils\helpers\generators\model\Generator */

echo $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'modelClass');

echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
//echo $form->field($generator, 'withSearchModel')->checkbox();
echo $form->field($generator, 'generateRelations')->dropDownList([
    Generator::RELATIONS_NONE        => 'No relations',
    Generator::RELATIONS_ALL         => 'All relations',
    Generator::RELATIONS_ALL_INVERSE => 'All relations with inverse',
]);
echo $form->field($generator, 'generateRelationsFromCurrentSchema')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
echo $form->field($generator, 'useSchemaName')->checkbox();

//This part is for Parent/Child Pattern
return;
//echo '<div class="well-lg panel panel-info">';
//echo $form->field($generator, 'typeParentChild')->dropDownList([
//    Generator::ROLE_NONE   => 'Not in a Parent/Child Pattern',
//    Generator::ROLE_PARENT => 'Plays Parent Role in P/C Pattern',
//    Generator::ROLE_CHILD  => 'Plays Child Role in P/C Pattern',
//]);
//echo $form->field($generator, 'relatedModel');
//echo $form->field($generator, 'relatedFields');
//
//echo '</div>';