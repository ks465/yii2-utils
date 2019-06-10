<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/01/19
 * Time: 09:24
 */

use khans\utils\components\StringHelper;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\component\Generator */

$id = Inflector::camel2id(StringHelper::basename($generator->targetModel));
$title = Inflector::camel2words(Inflector::singularize(StringHelper::basename($generator->targetModel)));
$action = str_replace('\\', '/', ltrim(StringHelper::dirname($generator->actionClass), '\\')) .
    '/' . Inflector::camel2id(str_replace('Action', '', StringHelper::basename($generator->actionClass)));

echo "<?php\n";
?>
use kartik\form\ActiveForm;
use kartik\popover\PopoverX;
use kartik\select2\Select2;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */

PopoverX::begin([
    'type' => PopoverX::TYPE_DEFAULT,
    'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
    'size' => PopoverX::SIZE_MEDIUM,
    'toggleButton' => [
        'label' => 'Select A <?= $title ?>' . ' <i class="glyphicon glyphicon-question-sign"></i>',
        'class' => 'btn btn-success',
    ],
    'header' => '<i class="glyphicon glyphicon-question-sign"></i> ' . 'Select A <?= $title ?>',
]);

$form = ActiveForm::begin([
    'fieldConfig' => ['showLabels' => false],
    'options' => ['id' => '<?= $id ?>-select-form'],
]);
echo Select2::widget([
    'name' => '<?= StringHelper::basename($generator->targetModel) ?>Select',
    'theme' => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'dir' => 'rtl',
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => Url::to(['<?= $action ?>']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
            'timeout' => 10000,
        ],
    ],
    'pluginEvents' => [
        "select2:select" => "function() {
            $('form#<?= $id ?>-select-form').submit();
        }",
    ]
]);
ActiveForm::end();

PopoverX::end();
