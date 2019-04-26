<?php
/**
 * This is the template for generating a AJAX CRUD index columns file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.3-980130
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
<?= $generator->enableEAV ? 'use khans\utils\tools\models\SysEavAttributes;' : '' ?>

use khans\utils\widgets\GridView;
use yii\helpers\Url;

$column = [
    'serial' => [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {
        if ($name == 'id') {
            echo "    // '$name' => [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        } elseif ($name == 'created_at' || $name == 'updated_at') {
            echo "    // '$name' => [\n";
            echo "        // 'class'     => '\khans\utils\columns\JalaliColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        } elseif ($name == 'created_by') {
            echo "    // '$name' => [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "        // 'value'     => function(\$model) { return \$model->getCreator()->fullName; },\n";
            echo "    // ],\n";
        } elseif ($name == 'updated_by') {
            echo "    // '$name' => [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "        // 'value'     => function(\$model) { return \$model->getUpdater()->fullName; },\n";
            echo "    // ],\n";
        } elseif ($name == 'status') {
            echo "    '$name' => [\n";
            echo "        'class'     => '\khans\utils\columns\EnumColumn',\n";
            echo "        'attribute' => '" . $name . "',\n";
            echo "        'enum'      => KHanModel::getStatuses()," . "\n";
            echo "    ],\n";
        }elseif (defined($generator->modelClass . '::THIS_TABLE_ROLE') and $generator->modelClass::THIS_TABLE_ROLE == 'ROLE_CHILD' and in_array($name, $generator->modelClass::getLinkFields())){
            echo "    '$name' => [\n";
            echo "        'class'     => '\khans\utils\columns\RelatedColumn',\n";
            echo "        'attribute' => '" . $name . "',\n";
            echo "        'parentController'=>'$generator->parentControllerId',\n";
            echo "    ],\n";
        } elseif (++$count < 6) {
            echo "    '$name' => [\n";
            echo "        'class'          => '\khans\utils\columns\DataColumn',\n";
            echo "        'attribute'      => '" . $name . "',\n";
            echo "        'hAlign'         => GridView::ALIGN_RIGHT," . "\n";
            echo "        'vAlign'         => GridView::ALIGN_MIDDLE," . "\n";
            echo "        'headerOptions'  => ['style' => 'text-align: center;']," . "\n";
            echo "        'contentOptions' => ['class' => 'pars-wrap']," . "\n";
            echo "    ],\n";
        } else {
            echo "    // '$name' => [\n";
            echo "        // 'class'     => '\khans\utils\columns\DataColumn',\n";
            echo "        // 'attribute' => '" . $name . "',\n";
            echo "    // ],\n";
        }
    }
    ?>
];

<?php if($generator->enableEAV): ?>
    foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->active()->all() as $field) {
        /* @var SysEavAttributes $field */
         if ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
            $column[$field->attr_name] = [
                'class'     => '\khans\utils\columns\BooleanColumn',
                'attribute' => $field->attr_name,
            ];
        } elseif ($field->attr_type == SysEavAttributes::DATA_TYPE_NUMBER) {
            $column[$field->attr_name] = [
                'class'     => '\khans\utils\columns\ArithmeticColumn',
                'attribute' => $field->attr_name,
            ];
        } else {
            $column[$field->attr_name] = [
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

$column['action'] =[
    'class'          => '\khans\utils\columns\ActionColumn',
    'runAsAjax'      => true,
    'audit'          => false,
    'visibleButtons' => [
        'delete' => false,
        'update' => false,
    ],
];

return $column;
