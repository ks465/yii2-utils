<?php
/**
 * This is the template for generating the ActiveQuery class.
 *
 * @package KHanS\Utils
 * @version 0.1.1-971126
 * @since   1.0
 */

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

echo "<?php\n";
?>

namespace <?= $generator->queryNs ?>;


use khans\utils\behaviors\EavQueryTrait;

/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 *
 * @package KHanS\Utils
 * @version 0.1.1-971126
 * @since   1.0
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->queryBaseClass, '\\') . "\n" ?>
{
    use EavQueryTrait;
}
