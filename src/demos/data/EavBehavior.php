<?php


namespace khans\utils\demos\data;

use yii\validators\Validator;

class EavBehavior extends \khans\utils\behaviors\EavBehavior
{
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
}