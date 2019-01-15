<?php

namespace khans\utils\tests\demos\models;


/**
 * This is the model class for table "columns_test".
 *
 * @property int $id
 * @property int $boolean_column A Boolean Column
 * @property int $tiny_column A Tiny Boolean
 * @property int $enum_column A Enum Column
 * @property string $string_date_column Jalali as String
 * @property int $integer_date_column Jalali as Integer
 * @property string $progress_column A Progress Column
 * @property int $related_column Relation to UpsertAggr
 * @property string $string_column String Column
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class ColumnsTest extends \khans\utils\models\KHanModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'columns_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['boolean_column', 'tiny_column', 'enum_column', 'integer_date_column', 'related_column'], 'integer'],
            [['string_date_column'], 'string', 'max' => 10],
            [['progress_column', 'string_column'], 'string', 'max' => 63],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'boolean_column' => 'A Boolean Column',
            'tiny_column' => 'A Tiny Boolean',
            'enum_column' => 'A Enum Column',
            'string_date_column' => 'Jalali as String',
            'integer_date_column' => 'Jalali as Integer',
            'progress_column' => 'A Progress Column',
            'related_column' => 'Relation to UpsertAggr',
            'string_column' => 'String Column',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\ColumnsTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\ColumnsTestQuery(get_called_class());
    }

    public function getParent(){
        return $this->hasOne(UpsertData::class, ['id' => 'related_column']);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge([
            'Workflow' => [
                'class' => '\khans\utils\behaviors\WorkflowBehavior',
                'statusAttribute' => 'progress_column',
                'propagateErrorsToModel' => true,
                'workflowID'=>'TestWF',
            ],
        ], parent::behaviors());
    }
}
