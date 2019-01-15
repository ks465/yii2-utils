<?php


namespace khans\utils\helpers\generators\model;

use yii\db\ActiveRecord;
use yii\gii\CodeFile;
use yii\db\Schema;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.2.0-971020
 * @since   1.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
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
}
