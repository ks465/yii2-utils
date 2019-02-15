<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.4-971125
 * @since   1.0
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use khans\utils\components\Jalali;
<?= $generator->enableEAV? 'use khans\utils\tools\models\SysEavAttributes;':'' ?>


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= strtr($generator->generateString($generator->tableTitle .
    ': {nameAttribute}', ['nameAttribute' => '{nameAttribute}']), [
    '{nameAttribute}\'' => '\' . $model->' . $generator->getNameAttribute()
]) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->tableTitle) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$attributes = [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        switch ($name){
            case 'status':
                echo "            [\n";
                echo "                'attribute' => '" . $name . "',\n";
                echo "                'value' => \$model->getStatus(),\n";
                echo "            ],\n";
                break;
            case 'created_at':
            case 'updated_at':
                echo "            [\n";
                echo "                'attribute' => '" . $name . "',\n";
                echo "                'value' => Jalali::date(Jalali::KHAN_LONG, '" . $name . "'),\n";
                echo "            ],\n";
                break;
            case 'created_by':
                echo "            [\n";
                echo "                'attribute' => '" . $name . "',\n";
                echo "                'value' => \$model->getCreator()->fullName,\n";
                echo "            ],\n";
                break;
            case 'updated_by':
                echo "            [\n";
                echo "                'attribute' => '" . $name . "',\n";
                echo "                'value' => \$model->getUpdater()->fullName,\n";
                echo "            ],\n";
                break;
            default:
                echo "            '" . $name . "',\n";
        }
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        switch ($column->name){
            case 'status':
                echo "    [\n";
                echo "        'attribute' => '" . $column->name . "',\n";
                echo "        'value' => \$model->getStatus(),\n";
                echo "    ],\n";
                break;
            case 'created_at':
            case 'updated_at':
                echo "    [\n";
                echo "        'attribute' => '" . $column->name . "',\n";
                echo "        'value' => Jalali::date(Jalali::KHAN_LONG, \$model->" . $column->name . "),\n";
                echo "    ],\n";
                break;
            case 'created_by':
                echo "    [\n";
                echo "        'attribute' => '" . $column->name . "',\n";
                echo "        'value' => \$model->getCreator()->fullName,\n";
                echo "    ],\n";
                break;
            case 'updated_by':
                echo "    [\n";
                echo "        'attribute' => '" . $column->name . "',\n";
                echo "        'value' => \$model->getUpdater()->fullName,\n";
                echo "    ],\n";
                break;
            default:
                $format = $generator->generateColumnFormat($column);
                echo "    '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
];

<?php if($generator->enableEAV): ?>
    foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == 'boolean') {
            $attributes[] = [
                'attribute' => $field->attr_name,
                'value'     => $model->getBooleanView($field->attr_name),
                'format'    => 'raw',
            ];
        } else {
            $attributes[] = [
                'attribute' => $field->attr_name,
            ];
        }
    }
<?php endif; ?>

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('ویرایش') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('پاک‌کن') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('آیا از پاک کردن این رکورد اطمینان دارید؟') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>

