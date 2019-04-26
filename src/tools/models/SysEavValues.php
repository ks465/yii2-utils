<?php


namespace khans\utils\tools\models;

use khans\utils\behaviors\ParentChildTrait;
use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_eav_values".
 *
 * @property int              $id ID
 * @property int              $attribute_id Attribute ID
 * @property int              $record_id Entity Table Record ID
 * @property string           $value Data Value
 *
 * @property SysEavAttributes $parent
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class SysEavValues extends \khans\utils\models\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'EAV Values Table';

    //<editor-fold Desc="Parent/Child Pattern">
    use ParentChildTrait;
    
    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_CHILD';
    
    /**
     * @var string Name of parent table
     */
    private static $parentTable = '\khans\utils\demos\data\SysEavAttributes';
    /**
     * @var array Foreign key(s) of this model linking primary key(s) in parent table.
     */
    private static $linkFields = ['attribute_id'];
    //</editor-fold>

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_eav_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['attribute_id', 'record_id', 'value'], 'required'],
            [
                ['attribute_id', 'record_id'],
                'integer',
            ],
            [['value'], 'string', 'max' => 1023],
            [
                ['attribute_id'], 'exist', 'skipOnError'     => true, 'targetClass' => SysEavAttributes::class,
                                           'targetAttribute' => ['attribute_id' => 'id'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
                'id'           => 'ID',
                'attribute_id' => 'Attribute ID',
                'record_id'    => 'Entity Table Record ID',
                'value'        => 'Data Value',
            ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysEavValuesQuery the active query used by this AR class.
     */
    public static function find(): KHanQuery
    {
        return new queries\SysEavValuesQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SysEavAttributes::class, ['id' => 'attribute_id']);
    }
}
