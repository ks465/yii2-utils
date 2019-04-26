<?php
/**
 * This is the template for generating the ActiveQuery class.
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
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

<?= ($generator->typeParentChild != \khans\utils\helpers\generators\model\Generator::ROLE_NONE) ? 'use \khans\utils\behaviors\ParentChildTrait;' : '' ?>

/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->queryBaseClass, '\\') . "\n" ?>
{
    <?= ($generator->typeParentChild != \khans\utils\helpers\generators\model\Generator::ROLE_NONE) ? "use ParentChildTrait;\n" : '' ?>
<?php if($generator->typeParentChild == \khans\utils\helpers\generators\model\Generator::ROLE_PARENT): ?>

    /**
     * Get an array suitable for Select2 selection dropdown
     *
     * @return array
     */
    public function getSelectionList()
    {
        return $this
            ->getTitle()
            ->all()
        ;
    }

    /**
     * Create a meaningful title for the list of system database tables
     *
     * @param string $title column name for the title field
     *
     * @return $this
     */
    public function getTitle($title = 'title')
    {
        return $this
            ->select(['id', $title => '<?= $generator->relatedFields ?>'])
            ->orderBy(['<?= $generator->relatedFields ?>' => SORT_ASC])
            ->asArray()
        ;
    }
<?php endif; ?>
}
