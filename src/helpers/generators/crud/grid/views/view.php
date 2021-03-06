<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.2-980425
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
<?= $generator->enableEAV ? 'use khans\utils\tools\models\SysEavAttributes;' : '' ?>
<?= (defined($generator->modelClass . '::THIS_TABLE_ROLE') and $generator->modelClass::THIS_TABLE_ROLE == 'ROLE_PARENT') ? 'use khans\utils\widgets\GridView;' : '' ?>

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

<?php
if(defined($generator->modelClass . '::THIS_TABLE_ROLE') and $generator->modelClass::THIS_TABLE_ROLE == 'ROLE_PARENT'):
    echo "<?php\n";
?>
$searchModel = new <?= $generator->childSearchModelClass ?>([
   'query'=> $model->getChildren(),
]);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$columns = require('<?= $generator->childColumnsPath ?>/_columns.php');
$columns['action']['controller'] = '<?= $generator->childControllerId ?>';
<?php
foreach (explode(',', $generator->childLinkFields) as $item){
    if(empty($item)){
        continue;
    }
    echo "unset(\$columns['$item']);\n";
}
?>
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-children-index">

    <h2>List of Child Data</h2>

    <div id="ajaxCrudDatatable">
        <?= "<?= " ?>GridView::widget([
            'id'                 => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-children-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => $columns,
            'export'             => true,
            'showRefreshButtons' => true,
            'itemLabelSingle'    => 'داده',
            'itemLabelPlural'    => 'داده‌ها',
            'bulkAction'         => [
                'action'  => 'bulk-delete',
                'label'   => 'پاک‌کن',
                'icon'    => 'trash',
                'class'   => 'btn btn-danger btn-xs',
                'message' => 'آیا اطمینان دارید همه را پا کنید؟',
            ],
            'createAction'       => [
                'ajax'    => true,
            ],
        ])?>
    </div>
</div>
<?php
endif;