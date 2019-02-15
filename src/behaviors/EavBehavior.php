<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 02/02/19
 * Time: 19:40
 */


namespace khans\utils\behaviors;

use khans\utils\models\KHanModel;
use khans\utils\tools\models\SysEavAttributes;
use khans\utils\tools\models\SysEavValues;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\validators\Validator;

/**
 * Class EavBehavior
 *
 * @package khans\utils\behaviors
 * @version 0.1.2-971125
 * @since   1.0
 *
 */
class EavBehavior extends Behavior
{
    /**
     * @var KHanModel|null the owner of this behavior
     */
    public $owner;
    /**
     * @var string table name of the owner class
     */
    public $id;

    /**
     * @var array list of EAV attributes
     */
    public $_attributes = [];
    /**
     * @var array list of values of the EAV attributes
     */
    public $_values = [];
    /**
     * @var array list of labels for the EAV attributes
     */
    public $_labels = [];

    /**
     * Define interesting events
     *
     * @return array
     */
    public function events(): array
    {
        return [
            KHanModel::EVENT_INIT         => 'eavInit',
            KHanModel::EVENT_AFTER_FIND   => 'eavAfterFind',
            KHanModel::EVENT_AFTER_INSERT => 'eavAfterEdit',
            KHanModel::EVENT_AFTER_UPDATE => 'eavAfterEdit',
            KHanModel::EVENT_AFTER_DELETE => 'eavAfterDelete',
        ];
    }

    /**
     * Event handler for initiating the owner class
     */
    public function eavInit()
    {
        $this->_attributes = $this->_labels = [];
        $validators = $this->owner->getValidators();
        foreach (SysEavAttributes::find()->where(['entity_table' => $this->id])->all() as $attribute) {
            /* @var SysEavAttributes $attribute */
            $validators[] = Validator::createValidator('safe', $this->owner, $attribute->attr_name, []);
//            $validators[] = Validator::createValidator($attribute->attr_type, $this->owner, $attribute->attr_name, []);

            $this->_labels[$attribute->attr_name] = $attribute->attr_label;

            $this->_values[$attribute->attr_name] = null;

            $this->_attributes[] = $attribute->attr_name;
        }
    }

    /**
     * Event handler for after finding a model
     */
    public function eavAfterFind()
    {
        $values = SysEavValues::find()
            ->joinWith(['parent'], false)
            ->select(['value', 'attr_name', 'attribute_id'])
            ->where(['entity_table' => $this->id])
            ->andWhere(['record_id' => $this->owner->primaryKey])
            ->indexBy('attr_name');

        if ($values->exists()) {
            $this->_values = $values->column();
        }
    }

    /**
     * Event handler for after updating or inserting a model
     */
    public function eavAfterEdit()
    {
        foreach ($this->_attributes as $attribute) {
            $attributeID = SysEavAttributes::find()->select(['id'])->where(['entity_table' => $this->id])->andWhere(['attr_name' => $attribute])->scalar();

            $valueModel = SysEavValues::find()->where(['attribute_id' => $attributeID])->andWhere(['record_id' => $this->owner->id])->one();
            if (empty($valueModel)) {
                $valueModel = new SysEavValues();
                $valueModel->attribute_id = $attributeID;
                $valueModel->record_id = $this->owner->id;
            }
            $valueModel->status = $this->owner->status;
            $valueModel->value = $this->owner->{$attribute};
            $valueModel->save();
        }
    }

    /**
     * Event handler for after deleting a model
     */
    public function eavAfterDelete()
    {
        foreach ($this->_attributes as $attribute) {
            $attributeID = SysEavAttributes::find()->select(['id'])->where(['entity_table' => $this->id])->andWhere(['attr_name' => $attribute])->scalar();

            $valueModel = SysEavValues::find()->where(['attribute_id' => $attributeID])->andWhere(['record_id' => $this->owner->id])->one();
            if (empty($valueModel)) {
                $valueModel = new SysEavValues();
                $valueModel->attribute_id = $attributeID;
                $valueModel->record_id = $this->owner->id;
            }
            $valueModel->status = $this->owner->status;
            $valueModel->value = $this->owner->{$attribute};
            $valueModel->delete();
        }
    }

    /**
     * Returns a value indicating whether a property can be read.
     *
     * A property is readable if:
     *
     * - the class has a getter method associated with the specified name
     *   (in this case, property name is case-insensitive);
     * - the class has a member variable with the specified name (when `$checkVars` is true);
     *
     * @param string $name the property name
     * @param bool   $checkVars whether to treat member variables as properties
     *
     * @return bool whether the property can be read
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true)
    {
        if (in_array($name, $this->_attributes)) {
            return true;
        }

        return parent::canGetProperty($name, $checkVars);
    }

    /**
     * Returns a value indicating whether a property can be set.
     *
     * A property is writable if:
     *
     * - the class has a setter method associated with the specified name
     *   (in this case, property name is case-insensitive);
     * - the class has a member variable with the specified name (when `$checkVars` is true);
     *
     * @param string $name the property name
     * @param bool   $checkVars whether to treat member variables as properties
     *
     * @return bool whether the property can be written
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true)
    {
        if (in_array($name, $this->_attributes)) {
            return true;
        }

        return parent::canSetProperty($name, $checkVars);
    }

    /**
     * Magic method to read a value from the EAV tables
     *
     * @param string $name requested attribute
     *
     * @return mixed
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            if (isset($this->_values[$name])) {
                return $this->_values[$name];
            }
        }
    }

    /**
     * Magic method to set values for EAV tables
     *
     * @param string $name changed attribute
     * @param mixed  $value new value for the attribute
     *
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            if (array_key_exists($name, $this->_values)) {
                $this->_values[$name] = $value;
            }
        }
    }
}
