<?php

namespace khans\utils\demos\data;

use Yii;
use \khans\utils\models\queries\KHanQuery;
use \khans\utils\behaviors\ParentChildTrait;

/**
 * This is the model class for table "pc_parents".
 *
 * @property string $tableComment Pc Parents
 *
 * @property int $id
 * @property string $oci_table
 * @property string $maria_table
 * @property string $maria_pk
 * @property string $comment
 * @property int $order
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property bool $is_applied
 * @property int $updated_by
 *
 * @property PcChildren[] $pcChildrens
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class PcParents extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'Pc Parents';

    //<editor-fold Desc="Parent/Child Pattern">
    use ParentChildTrait;
    
    //This is used for creating required CRUD config!
    const THIS_TABLE_ROLE = 'ROLE_PARENT';
    
    /**
     * @var string Name of child table
     */
    private static $childTable = '\khans\utils\demos\data\PcChildren';
    /**
     * @var string Name of field containing descriptive title for the record
     */
    private static $titleField = 'comment';
    //</editor-fold>

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'pc_parents';
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
            [['comment'], 'string'],
            [['order', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['is_applied'], 'boolean'],
            [['oci_table', 'maria_table', 'maria_pk'], 'string', 'max' => 20],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
            'id' => 'ID',
            'oci_table' => 'Oci Table',
            'maria_table' => 'Maria Table',
            'maria_pk' => 'Maria Pk',
            'comment' => 'Comment',
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
    public function getPcChildrens()
    {
        return $this->hasMany(PcChildren::className(), ['table_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PcParentsQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new PcParentsQuery(get_called_class());
    }
}
