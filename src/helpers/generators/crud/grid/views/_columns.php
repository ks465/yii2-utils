<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
use khans\utils\models\KHanModel;
use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
    [
        'class'          => 'kartik\grid\CheckboxColumn',
        'width'          => '20px',
    ],
    [
        'class'          => 'kartik\grid\SerialColumn',
        'width'          => '30px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {
        if ($name=='id'||$name=='created_at'||$name=='updated_at'){
            echo "    // [\n";
            echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "    // ],\n";
        } else if (++$count < 6) {
            echo "    [\n";
            echo "        'class'          => '\khans\utils\columns\DataColumn',\n";
            echo "        'attribute'      => '" . $name . "',\n";
            echo "        'hAlign'         => GridView::ALIGN_RIGHT," . "\n";
            echo "        'vAlign'         => GridView::ALIGN_MIDDLE," . "\n";
            echo "        'headerOptions'  => ['style' => 'text-align: center;']," . "\n";
            echo "        'contentOptions' => ['class' => 'pars-wrap']," . "\n";
            echo "    ],\n";
        } else {
            echo "    // [\n";
            echo "        // 'class'=>'\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "    // ],\n";
        }
    }
    ?>
    [
        'class'          => '\khans\utils\columns\EnumColumn',
        'attribute'      => 'status',
        'enum'           => KHanModel::getStatuses(),
    ],
    [
        'class'          => '\khans\utils\columns\ActionColumn',
        'runAsAjax'      => false,
    ],
];

return $column;
