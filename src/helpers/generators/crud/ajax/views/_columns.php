<?php
/**
 * This is the template for generating a AJAX CRUD index columns file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971013
 * @since   1.0
 */
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
        if ($name == 'id' || $name == 'created_at' || $name == 'updated_at') {
            echo "    // [\n";
            echo "        // 'class'        => '\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'    => '" . $name . "',\n";
            echo "    // ],\n";
        } elseif ($name == 'status') {
            echo "    [\n";
            echo "        'class'          => '\khans\utils\columns\EnumColumn',\n";
            echo "        'attribute'      => '" . $name . "',\n";
            echo "        'enum'           => KHanModel::getStatuses()," . "\n";
            echo "    ],\n";
        } elseif (++$count < 6) {
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
            echo "        // 'class'         => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute'     => '" . $name . "',\n";
            echo "    // ],\n";
        }
    }
    ?>
    [
        'class'          => '\khans\utils\columns\ActionColumn',
        'runAsAjax'      => true,
    ],
];

return $column;
