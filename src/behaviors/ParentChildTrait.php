<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 04/10/19
 * Time: 19:40
 */


namespace khans\utils\behaviors;

use khans\utils\components\ArrayHelper;
use khans\utils\models\KHanModel;
use khans\utils\models\queries\KHanQuery;
use yii\base\Exception;
use yii\helpers\Html;

/**
 * Trait ParentChildTrait adds required properties methods to models to enable utilities to connect together.
 * This trait is used equally for parent and child models.
 *
 * The parent model should use this trait and set these two properties:
 *
 * ```php
 * use ParentChildTrait;
 *
 * private static $titleField = 'name_of_field_in_parent_model_act_as_a_title_for_each_record';
 * private $childTable = \path\to\ChildModel::class;
 * ```
 *
 * The child model should use this trait and set these two properties:
 *
 * ```php
 * use ParentChildTrait;
 *
 * private static $linkFields = ['reference_key_to_parent_record'];
 * private $parentTable = '\path\to\ParentModel';
 * ```
 *
 * @package KHanS\Utils
 * @version 0.1.0-980121
 * @since   1.0
 *
 * @property KHanModel   $parent
 * @property KHanModel[] $children
 * @property string[]    $linkFields
 * @property KHanModel   $parentTable
 * @property KHanModel[] $childTable
 * @property string      $parentTitle
 */
trait ParentChildTrait
{
    /**
     * Getter for model parentTable. [parentTable] must be defined in child models.
     *
     * @return string
     */
    public static function getParentTable(): string
    {
        return self::$parentTable;
    }

    /**
     * Getter for model childTable. [childTable] must be defined in parent models.
     *
     * @return string
     */
    public static function getChildTable(): string
    {
        return self::$childTable;
    }

    /**
     * Getter for list of fields in child class referring to the parent class
     *
     * @return string[]
     */
    public static function getLinkFields(): array
    {
        return self::$linkFields;
    }

    /**
     * Getter for name of the field utilized to act as label of each record
     *
     * @return string
     */
    public static function getTitleField(): string
    {
        return self::$titleField;
    }

    /**
     * Return a model for the parent class in this is indeed a child role
     *
     * @return KHanQuery
     * @throws Exception
     */
    public function getParent()
    {
        if ($this->parentTable === false) {
            throw new Exception('Something Wrong in `getParent`');
        }

        $link = array_combine($this->parentTable::primaryKey(), $this->linkFields);

        return $this->hasOne($this->parentTable, $link);
    }

    /**
     * Get value of title field from the parent table.
     * For new models return empty.
     *
     * @return string
     */
    public function getParentTitle(): string
    {
        if (empty($this->parent)) {
            return '';
        }

        return $this->parent->{$this->parent->getTitleField()};
    }

    /**
     * Return array of children if this is indeed a parent role
     *
     * @return KHanQuery[]
     * @throws Exception
     */
    public function getChildren()
    {
        if ($this->childTable === false) {
            throw new Exception('Something Wrong in `getChildren`');
        }

        $link = array_combine($this->childTable::getLinkFields(), $this->primaryKey());

        return $this->hasMany($this->childTable, $link);
    }

//    /**
//     * Get an array suitable for filtering children of a given model
//     *
//     * @return array|false
//     */
//    public function getChildrenCondition()
//    {
//        return array_combine($this->childTable::getLinkFields(), $this->getPrimaryKey(true));
//    }
//
//    /**
//     * Create a meaningful title for the list of system database tables
//     *
//     * @param string $title column name for the title field
//     *
//     * @return $this
//     */
//    public function getTitle($title = 'title')
//    {
//        return $this
//            ->select(['id', $title => 'CONCAT([[comment]], " (", [[oci_table]], ")")'])
//            ->orderBy(['comment' => SORT_ASC])
//            ->orderBy([$table::getTitleField()=> SORT_ASC])
//
//            ->asArray();
//    }
}