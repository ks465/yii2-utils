<?php

namespace khans\utils\tests\demos\models;

use Yii;

/**
 * This is the model class for table "upsert_aggr".
 *
 * @property string $grade
 * @property int $field
 * @property int $year
 * @property string $status
 * @property int $counter
 * @property string $r_a
 * @property string $r_b
 * @property int $created_by
 * @property int $updated_by
 */
class UpsertAggr extends \khans\pgrad\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upsert_aggr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade', 'field', 'year', 'status', 'counter', 'r_a', 'r_b'], 'required'],
            [['field', 'year', 'counter', 'created_by', 'updated_by'], 'integer'],
            [['r_a', 'r_b'], 'number'],
            [['grade'], 'string', 'max' => 3],
            [['status'], 'string', 'max' => 40],
            [['grade', 'field', 'year', 'status'], 'unique', 'targetAttribute' => ['grade', 'field', 'year', 'status']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'grade' => 'Grade',
            'field' => 'Field',
            'year' => 'Year',
            'status' => 'Status',
            'counter' => 'Counter',
            'r_a' => 'R A',
            'r_b' => 'R B',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\UpsertAggrQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\UpsertAggrQuery(get_called_class());
    }
}
