<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980130
 * @since   1.0
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;
<?= $generator->enableEAV? 'use khans\utils\tools\models\SysEavAttributes;':'' ?>


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

<?='if (!Yii::$app->request->isAjax) {'."\n" ?>
    $this->title = <?= strtr($generator->generateString($generator->tableTitle .
        ': {nameAttribute}', ['nameAttribute' => '{nameAttribute}']), [
        '{nameAttribute}\'' => '\' . $model->' . $generator->getNameAttribute()
    ]) ?>;
    $this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->tableTitle) ?>, 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
<?="}\n" ?>

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
                if (defined($generator->modelClass . '::THIS_TABLE_ROLE') and $generator->modelClass::THIS_TABLE_ROLE == 'ROLE_CHILD' and in_array($name, $generator->modelClass::getLinkFields())){
                    echo "    '$name' => [\n";
                    echo "                'attribute' => '" . $name . "',\n";
                    echo "                'value' => \$model->getParentTitle() . Html::a('abc'\n";
                    echo "                       ['$generator->parentControllerId/view'] +\n";
                    echo "                       array_combine(\$model->parent::primaryKey(), ArrayHelper::filter(\$model->attributes, \$model->getLinkFields())\n";
                    echo "                ),\n";
                    echo "                'format'=>'html',\n";
                    echo "    ],\n";
                }else{
                    echo "            '" . $name . "',\n";
                }
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
                if (defined($generator->modelClass . '::THIS_TABLE_ROLE') and $generator->modelClass::THIS_TABLE_ROLE == 'ROLE_CHILD' and in_array($column->name, $generator->modelClass::getLinkFields())){
                    echo "    [\n";
                    echo "        'attribute' => '" . $column->name . "',\n";
                    echo "        'value' => \$model->getParentTitle() . Html::a(' <i class=\"glyphicon glyphicon-link\"></i>',\n";
                    echo "               ['$generator->parentControllerId/view'] +\n";
                    echo "               array_combine(\$model->parent::primaryKey(), khans\utils\components\ArrayHelper::filter(\$model->attributes, \$model->getLinkFields())\n";
                    echo "        )),\n";
                    echo "        'format'=>'html',\n";
                    echo "    ],\n";
                }else{
                    $format = $generator->generateColumnFormat($column);
                    echo "    '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
        }
    }
}
?>
];

<?php if($generator->enableEAV): ?>
    foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->all() as $field) {
        /* @var SysEavAttributes $field */
        if ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
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
<?='<?php if (!Yii::$app->request->isAjax): ?>'."\n" ?>
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?="<?php endif; ?>\n" ?>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>
