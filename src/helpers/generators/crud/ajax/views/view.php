<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

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
