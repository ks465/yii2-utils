<?php

namespace khans\utils\demos\data;

use Yii;
use \khans\utils\models\queries\KHanQuery;


/**
 * This is the model class for table "test_workflow_mixed".
 *
 * @property string $tableComment Test Workflow Mixed
 *
 * @property int $id
 * @property string $title
 * @property string $workflow_status
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */
class TestWorkflowMixed extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'Test Workflow Mixed';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'test_workflow_mixed';
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
            [['title', 'workflow_status'], 'string'],
            [['status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
            'id' => 'ID',
            'title' => 'Title',
            'workflow_status' => 'Workflow Status',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
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
                'class'                  => '\khans\utils\components\workflow\WorkflowBehavior',
                'statusAttribute'        => 'workflow_status',
                'propagateErrorsToModel' => true,
                'autoInsert'             => false,
                'defaultWorkflowId'      => 'WF',
            ],
        ], parent::behaviors());
    }
    /**
     * {@inheritdoc}
     * @return TestWorkflowMixedQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new TestWorkflowMixedQuery(get_called_class());
    }
}
