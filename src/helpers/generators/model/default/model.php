<?php
/**
 * This is the template for generating the model class of a specified table.
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

if(!empty($tableSchema->primaryKey)){
    $pk = "['" . implode("', '", $tableSchema->primaryKey) . "']";
}elseif (!empty($generator->optionalPK)) {
    $pk = "['" . implode("', '", $generator->optionalPK) . "']";
}else{
    $pk ='[]';
}

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use \khans\utils\models\queries\KHanQuery;
<?= ($generator->typeParentChild != \khans\utils\helpers\generators\model\Generator::ROLE_NONE) ? 'use \khans\utils\behaviors\ParentChildTrait;' : '' ?>


/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
 * @property string $tableComment <?= $generator->getTableComment($tableName) ?>

 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = '<?= $generator->getTableComment($tableName) ?>';

<?php
switch($generator->typeParentChild){
    case \khans\utils\helpers\generators\model\Generator::ROLE_NONE:
        break;
    case \khans\utils\helpers\generators\model\Generator::ROLE_PARENT:
        echo <<<PCP
    //<editor-fold Desc="Parent/Child Pattern">
    use ParentChildTrait;
    
    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_PARENT';
    
    /**
     * @var string Name of child table
     */
    private static \$childTable = '$generator->relatedModel';
    /**
     * @var string Name of field containing descriptive title for the record
     */
    private static \$titleField = '$generator->relatedFields';
    //</editor-fold>

PCP;
        break;
    case \khans\utils\helpers\generators\model\Generator::ROLE_CHILD:
        echo <<<PCP
    //<editor-fold Desc="Parent/Child Pattern">
    use \khans\utils\behaviors\ParentChildTrait;
    
    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_CHILD';
    
    /**
     * @var string Name of parent table
     */
    private static \$parentTable = '$generator->relatedModel';
    /**
     * @var array Foreign key(s) of this model linking primary key(s) in parent table.
     */
    private static \$linkFields = $generator->generatedRelation;
    //</editor-fold>

PCP;
        break;
}
?>

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>
<?php if (!empty($generator->optionalPK)): ?>

    /**
     * @return string[] primary key(s).
     */
    public static function primaryKey()
    {
        return <?= $pk ?>;
    }
<?php endif; ?>
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php
endforeach;

if ($queryClassName):
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find(): <?= '\\' . ltrim($generator->queryBaseClass, '\\') ?>
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
