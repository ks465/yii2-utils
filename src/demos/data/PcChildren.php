<?php

namespace khans\utils\demos\data;

use Yii;
use \khans\utils\models\queries\KHanQuery;
use \khans\utils\behaviors\ParentChildTrait;

/**
 * This is the model class for table "pc_children".
 *
 * @property string $tableComment Pc Children
 *
 * @property int $id
 * @property int $table_id
 * @property string $oci_field
 * @property string $oci_type
 * @property int $oci_length
 * @property string $maria_field
 * @property string $maria_format
 * @property string $label
 * @property int $reference_table
 * @property int $reference_field
 * @property int $order
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property bool $is_applied
 * @property int $updated_by
 *
 * @property PcParents $table
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class PcChildren extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'Pc Children';

    //<editor-fold Desc="Parent/Child Pattern">
    use \khans\utils\behaviors\ParentChildTrait;
    
    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_CHILD';
    
    /**
     * @var string Name of parent table
     */
    private static $parentTable = '\khans\utils\demos\data\PcParents';
    /**
     * @var array Foreign key(s) of this model linking primary key(s) in parent table.
     */
    private static $linkFields = ['table_id'];
    //</editor-fold>

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'pc_children';
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
            [['table_id', 'oci_length', 'reference_table', 'reference_field', 'order', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['oci_field', 'oci_type', 'maria_field', 'maria_format', 'label'], 'string'],
            [['is_applied'], 'boolean'],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => PcParents::className(), 'targetAttribute' => ['table_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
            'id' => 'ID',
            'table_id' => 'Table ID',
            'oci_field' => 'Oci Field',
            'oci_type' => 'Oci Type',
            'oci_length' => 'Oci Length',
            'maria_field' => 'Maria Field',
            'maria_format' => 'Maria Format',
            'label' => 'Label',
            'reference_table' => 'Reference Table',
            'reference_field' => 'Reference Field',
            'order' => 'Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'is_applied' => 'Is Applied',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(PcParents::className(), ['id' => 'table_id']);
    }

    /**
     * {@inheritdoc}
     * @return PcChildrenQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new PcChildrenQuery(get_called_class());
    }
}
