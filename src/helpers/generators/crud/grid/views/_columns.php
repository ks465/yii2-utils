<?php
/**
 * This is the template for generating a CRUD index columns file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-971125
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
<?= $generator->enableEAV? 'use khans\utils\tools\models\SysEavAttributes;':'' ?>

use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {
        if ($name == 'id') {
            echo "    // [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        } elseif ($name == 'created_at' || $name == 'updated_at') {
            echo "    // [\n";
            echo "        // 'class'     => '\khans\utils\columns\JalaliColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        } elseif ($name == 'created_by') {
            echo "    // [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "        // 'value'     => function(\$model) { return \$model->getCreator()->fullName; },\n";
            echo "    // ],\n";
        } elseif ($name == 'updated_by') {
            echo "    // [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "        // 'value'     => function(\$model) { return \$model->getUpdater()->fullName; },\n";
            echo "    // ],\n";
        } elseif ($name == 'status') {
            echo "    [\n";
            echo "        'class'     => '\khans\utils\columns\EnumColumn',\n";
            echo "        'attribute' => '" . $name . "',\n";
            echo "        'enum'      => KHanModel::getStatuses()," . "\n";
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
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        }
    }
    ?>
];

<?php if($generator->enableEAV): ?>
    foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->all() as $field) {
        /* @var SysEavAttributes $field */
       if ($field->attr_type == 'boolean') {
            $column[] = [
                'class'     => '\khans\utils\columns\BooleanColumn',
                'attribute' => $field->attr_name,
                'format'    => 'raw',
                'hAlign'    => GridView::ALIGN_CENTER,
                'vAlign'    => GridView::ALIGN_MIDDLE,
            ];
        } else {
            $column[] = [
                'class'          => '\khans\utils\columns\DataColumn',
                'attribute'      => $field->attr_name,
                'hAlign'         => GridView::ALIGN_RIGHT,
                'vAlign'         => GridView::ALIGN_MIDDLE,
                'headerOptions'  => ['style' => 'text-align: center;'],
                'contentOptions' => ['class' => 'pars-wrap'],
            ];
        }
    }
<?php endif; ?>

$column[] =[
        'class'      => '\khans\utils\columns\ActionColumn',
        'runAsAjax'  => true,
    ];

return $column;
