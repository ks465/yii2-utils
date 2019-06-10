<?php


namespace khans\utils\demos\data;

use Yii;

/**
 * This is the model class for table "multi_format_data".
 *
 * @property string $tableComment Multi Format Data
 *
 * @property int    $pk_column
 * @property int    $integer_column
 * @property string $text_column
 * @property double $real_column
 * @property int    $boolean_column
 * @property int    $timestamp_column
 * @property string $progress_column
 * @property int    $status
 * @property int    $created_at
 * @property int    $created_by
 * @property int    $updated_at
 * @property int    $updated_by
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class MultiFormatData extends KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'Multi Format Data';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'multi_format_data';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
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
            [
                [
                    'integer_column', 'timestamp_column', 'status', 'created_at', 'created_by', 'updated_at',
                    'updated_by',
                ], 'integer',
            ],
            [['text_column', 'progress_column'], 'string'],
            [['real_column'], 'number'],
            [['boolean_column'], 'boolean'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
                'pk_column'        => 'Pk Column',
                'integer_column'   => 'Integer Column',
                'text_column'      => 'Text Column',
                'real_column'      => 'Real Column',
                'boolean_column'   => 'Boolean Column',
                'timestamp_column' => 'Timestamp Column',
                'progress_column'  => 'Progress Column',
                'status'           => 'Status',
                'created_at'       => 'Created At',
                'created_by'       => 'Created By',
                'updated_at'       => 'Updated At',
                'updated_by'       => 'Updated By',
            ];
    }
    /**
     * {@inheritdoc}
     * @return MultiFormatDataQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new MultiFormatDataQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        /* Facilitate reading workflow definitions from demo section.
         * This is not very clean and nice way, but it ensures that demo workflow works
         * in any configuration of the main application.
         * Note: This demo does not use array loader as is the case in the documentations!
         */
        Yii::$app->set('workflowSource',
            Yii::createObject([
                'class' => 'raoul2000\workflow\source\file\WorkflowFileSource',
                'definitionLoader' => [
                    'class' => 'raoul2000\workflow\source\file\PhpClassLoader',
                    'namespace'  => 'khans\\utils\\demos\\workflow'
                ]
            ])
        );
        Yii::setAlias('@workflowDefinitionNamespace', 'khans\\utils\\demos\\workflow');

        return array_merge([
            'Workflow' => [
                'class'                  => '\khans\utils\behaviors\WorkflowBehavior',
                'statusAttribute'        => 'progress_column',
                'propagateErrorsToModel' => true,
                'autoInsert'             => false,
                'defaultWorkflowId'      => 'WF',
            ],
        ], parent::behaviors());
    }
}
