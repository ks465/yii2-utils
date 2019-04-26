<?php

namespace khans\utils\demos\data;

use Yii;
use \khans\utils\models\queries\KHanQuery;
use \khans\utils\behaviors\ParentChildTrait;
use yii\db\Query;

/**
 * This is the model class for table "sys_eav_values".
 *
 * @property string $tableComment EAV Values Table
 *
 * @property int $id
 * @property int $attribute_id
 * @property int $record_id
 * @property string $value
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SysEavAttributes $attribute0
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class SysEavValues extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'EAV Values Table';

    //<editor-fold Desc="Parent/Child Pattern">
    use \khans\utils\behaviors\ParentChildTrait;
    
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
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('test');
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['attribute_id', 'record_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysEavAttributes::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
            'id' => 'ID',
            'attribute_id' => 'Attribute ID',
            'record_id' => 'Record ID',
            'value' => 'Value',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(SysEavAttributes::className(), ['id' => 'attribute_id']);
    }

    /**
     * {@inheritdoc}
     * @return SysEavValuesQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new SysEavValuesQuery(get_called_class());
    }
}
