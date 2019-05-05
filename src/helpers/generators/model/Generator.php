<?php


namespace khans\utils\helpers\generators\model;

use khans\utils\tools\components\TableHelper;
use Yii;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
    const ROLE_NONE = 'none';
    const ROLE_PARENT = 'parent';
    const ROLE_CHILD = 'child';
    /**
     * @var string type of Parent/Child pattern used for this model. @see [ParentChildTrait]
     */
    public $typeParentChild = self::ROLE_NONE;
    /**
     * @var string List of fields used to link child to parent table, or used to read title from parent table
     */
    public $relatedFields;
    /**
     * @var string Name of Parent or Child model to be used in the relation
     */
    public $relatedModel;
    /**
     * @var string Comma separated list of fields to use in the primaryKey() method of the generated model,
     * when the table does not have primary key
     */
    public $optionalPK;

    /**
     * Prepare array of linked fields in a string notation to inject into the model
     *
     * @return string
     */
    public function getGeneratedRelation()
    {
        $relatedFields = $this->getFieldIDs();

        return "['" . implode("', '", $relatedFields) . "']";
    }

    /**
     * @var bool build search model alongside the data model
     */
    public $withSearchModel = true;
    /**
     * @var string namespace for the generated model
     */
    public $ns = 'khans\utils\models';
    /**
     * @var string FQN of the base class for the generated model
     */
    public $baseClass = 'khans\utils\models\KHanModel';
    /**
     * @var bool generate labels for attributes from table comments
     */
    public $generateLabelsFromComments = true;
    /**
     * @var bool generate query for the model
     */
    public $generateQuery = true;
    /**
     * @var string namespace for the generated queries
     */
    public $queryNs = 'khans\utils\models\queries';
    /**
     * @var string FQN of the base model for queries
     */
    public $queryBaseClass = 'khans\utils\models\queries\KHanQuery';

    /**
     * @var array list of tables when using wildcards in table name
     */
    protected $tableNames;
    /**
     * @var array list of models when using wildcards in table name
     */
    protected $classNames;

    /**
     * @return string name of the code generator
     */
    public function getName()
    {
        return 'KHan Model Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription()
    {
        return '<div class=" alert alert-info">' .
            'This generator generates an ActiveRecord class for the specified database table based on KHanModel.' .
            '</div>';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['typeParentChild'], 'in', 'range' => [self::ROLE_NONE, self::ROLE_PARENT, self::ROLE_CHILD]],
            [['withSearchModel'], 'boolean'],
            [['relatedModel', 'relatedFields', 'optionalPK'], 'filter', 'filter' => 'trim'],
//            [['relatedModel'], 'validateClass'],
//            [['relatedFields'], 'validateLinkedFields'],
        ]);
    }

    /**
     * Validates the [[tableName]] attribute.
     */
    public function validateLinkedFields()
    {
        $db = $this->getDbConnection();
        $relatedFields = $this->getFieldIDs();

        if ($this->typeParentChild == self::ROLE_PARENT) {
            if (count($relatedFields) > 1) {
                $this->addError('relatedFields', "Currently only one title field could be defined.");

                return;
            }
        }

        foreach ($this->getTableNames() as $tableName) {
            $tableSchema = $db->getTableSchema($tableName);
            $unknownFields = array_diff($relatedFields, $tableSchema->columnNames);
            if (!empty($unknownFields)) {
                $this->addError('relatedFields', "Not all requested fields exists in the table(s).");
            }
        }
    }

    /**
     * Normalizes [[relatedFields]] into an array of fields names.
     *
     * @return array an array of fields names entered by the user
     */
    public function getFieldIDs()
    {
        $relatedFields = array_unique(preg_split('/[\s,]+/', $this->relatedFields, -1, PREG_SPLIT_NO_EMPTY));
        sort($relatedFields);

        return $relatedFields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'typeParentChild' => 'Use This Model in Parent/Child Pattern?',
            'withSearchModel' => 'Generate searchModel?',
            'relatedModel'    => 'Name of Parent or Child Model',
            'relatedFields'   => 'Field containing Parent.Title of Child.Foreign Keys',
            'optionalPK'      => 'Optional primary key(s) for the model.',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'typeParentChild' => 'If using a Parent/Child Pattern, which role does this model plays.',
            'withSearchModel' => 'Create SearchModel alongside main model and query model?',
            'relatedModel'    => 'Name of Parent or Child model --based on the chosen type-- to use for connection',
            'relatedFields'   => 'Field containing record title in Parent model, or fields linking to parent in Child model',
            'optionalPK'      => 'This is useful for situations that the table does not contain real primary key. Enter comma separated of the columns in the PK here.',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes());
    }

    /**
     * If title is not given in the config, produce it from comment of the table in database.
     * If comment is not available return Table Name
     *
     * @param string $tableName Name of table to get the comment
     *
     * @return string
     */
    public function getTableComment($tableName)
    {
        return TableHelper::getTableComment($tableName);
    }
}
