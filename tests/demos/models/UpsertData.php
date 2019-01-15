<?php

namespace khans\utils\tests\demos\models;

use Yii;

/**
 * This is the model class for table "upsert_data".
 *
 * @property string $grade
 * @property int $field
 * @property int $year
 * @property int $faculty
 * @property string $status
 * @property string $r_a
 * @property string $r_b
 * @property int $created_by
 * @property int $updated_by
 */
class UpsertData extends \khans\pgrad\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upsert_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade', 'field', 'year', 'faculty', 'status', 'r_a', 'r_b'], 'required'],
            [['field', 'year', 'faculty', 'created_by', 'updated_by'], 'integer'],
            [['r_a', 'r_b'], 'number'],
            [['grade'], 'string', 'max' => 3],
            [['status'], 'string', 'max' => 40],
            [['grade', 'field', 'year', 'faculty'], 'unique', 'targetAttribute' => ['grade', 'field', 'year', 'faculty']],
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
            'faculty' => 'Faculty',
            'status' => 'Status',
            'r_a' => 'R A',
            'r_b' => 'R B',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\UpsertDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\UpsertDataQuery(get_called_class());
    }
}
