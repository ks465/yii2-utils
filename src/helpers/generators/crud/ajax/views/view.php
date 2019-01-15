<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971013
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

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

<?='if (!Yii::$app->request->isAjax) {'."\n" ?>
    $this->title = <?= strtr($generator->generateString('ویرایش ' .
        $generator->tableTitle .
        ': {nameAttribute}', ['nameAttribute' => '{nameAttribute}']), [
        '{nameAttribute}\'' => '\' . $model->' . $generator->getNameAttribute()
    ]) ?>;
    $this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->tableTitle) ?>, 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
<?="}\n" ?>
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
<?='<?php if (!Yii::$app->request->isAjax) { ?>'."\n" ?>
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
<?="<?php } ?>\n" ?>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    if($name == 'created_at' || $name == 'updated_at'){
                        echo "            [\n";
                        echo "                'attribute' => '" . $name . "',\n";
                        echo "                'value' => Jalali::date(Jalali::KHAN_LONG, '" . $name . "'),\n";
                        echo "            ],\n";
                    }else{
                        echo "            '" . $name . "',\n";
                    }
                }
            } else {
                foreach ($generator->getTableSchema()->columns as $column) {
                    if($column->name == 'created_at' || $column->name == 'updated_at'){
                        echo "            [\n";
                        echo "                'attribute' => '" . $column->name . "',\n";
                        echo "                'value' => Jalali::date(Jalali::KHAN_LONG, \$model->" . $column->name . "),\n";
                        echo "            ],\n";
                    }else{
                        $format = $generator->generateColumnFormat($column);
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
            }
            ?>
        ],
    ]) ?>

</div>
