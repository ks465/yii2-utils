<?php


namespace khans\utils\tools\models;

use khans\utils\behaviors\ParentChildTrait;
use khans\utils\components\ArrayHelper;
use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_eav_attributes".
 *
 * @property string         $tableComment EAV Attributes Table
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
 * @version 0.3.0-980123
 * @since   1.0
 */
class SysEavAttributes extends \khans\utils\models\KHanModel
{
    const DATA_TYPE_NUMBER = 'number';
    const DATA_TYPE_BOOLEAN = 'boolean';
    const DATA_TYPE_STRING = 'string';
    private static $_dataTypes = [
        SysEavAttributes::DATA_TYPE_NUMBER  => 'رقمی',
        SysEavAttributes::DATA_TYPE_BOOLEAN => 'منطقی',
        SysEavAttributes::DATA_TYPE_STRING  => 'رشته‌ای',
    ];

    /**
     * Get list of available data types.
     *
     * @return array
     */
    public static function getDataTypes(): array
    {
        return SysEavAttributes::$_dataTypes;
    }

    /**
     * Get the title for data type of the given record or value
     *
     * @param null|integer $dataType current status id
     *
     * @return string label for the status
     */
    public function getDataType($dataType = null): string
    {
        if (empty($dataType)) {
            return ArrayHelper::getValue(static::getDataTypes(), $this->attr_type, 'نامشخص');
        }

        return ArrayHelper::getValue(static::getDataTypes(), $dataType, 'نامشخص');
    }

    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'EAV Attributes Table';

    //<editor-fold Desc="Parent/Child Pattern">
    use ParentChildTrait;

    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_PARENT';

    /**
     * @var string Name of child table
     */
    private static $childTable = '\khans\utils\demos\data\SysEavValues';
    /**
     * @var string Name of field containing descriptive title for the record
     */
    private static $titleField = 'attr_label';
    //</editor-fold>

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
            [['attr_type'], 'in', 'range' => array_keys(SysEavAttributes::getDataTypes())],
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
