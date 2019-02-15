<?php


namespace khans\utils\tools\models;

use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_eav_attributes".
 *
 * @property int            $id ID
 * @property string         $entity_table Entity Table
 * @property string         $attr_name Attribute Name
 * @property string         $attr_label Attribute Label
 * @property string         $attr_type Data Type
 * @property string         $attr_length Data Length
 * @property string         $attr_scenario Scenario When the Attribute is Active
 *
 * @property SysEavValues[] $sysEavValues
 *
 * @package KHanS\Utils
 * @version 0.2.0-971114
 * @since   1.0
 */
class SysEavAttributes extends \khans\utils\models\KHanModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_eav_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['entity_table', 'attr_name', 'attr_label', 'attr_type'], 'required'],
            ['attr_scenario', 'default', 'value' => 'default'],
            [['attr_type'], 'string'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['entity_table', 'attr_name'], 'string', 'max' => 63],
            [['attr_label'], 'string', 'max' => 127],
            [['attr_length', 'attr_scenario'], 'string', 'max' => 31],
            [['entity_table', 'attr_name'], 'unique', 'targetAttribute' => ['entity_table', 'attr_name']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
                'id'            => 'ID',
                'entity_table'  => 'Entity Table',
                'attr_name'     => 'Attribute Name',
                'attr_label'    => 'Attribute Label',
                'attr_type'     => 'Data Type',
                'attr_length'   => 'Data Length',
                'attr_scenario' => 'Scenario When the Attribute is Active',
                'status'        => 'وضعیت رکورد',
                'created_by'    => 'سازنده',
                'updated_by'    => 'ویرایشگر',
                'created_at'    => 'زمان افزودن',
                'updated_at'    => 'زمان آخرین ویرایش',
            ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysEavAttributesQuery the active query used by this AR class.
     */
    public static function find(): KHanQuery
    {
        return new queries\SysEavAttributesQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysEavValues()
    {
        return $this->hasMany(SysEavValues::class, ['attribute_id' => 'id']);
    }
}
