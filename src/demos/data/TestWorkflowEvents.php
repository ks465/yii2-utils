<?php


namespace khans\utils\demos\data;

use Yii;


/**
 * This is the model class for table "test_workflow_events".
 *
 * @property string $tableComment Test Workflow Events
 *
 * @property int    $id
 * @property string $title
 * @property string $workflow_status
 * @property int    $status
 * @property int    $created_by
 * @property int    $created_at
 * @property int    $updated_by
 * @property int    $updated_at
 *
 * @package KHanS\Utils
 * @version 0.3.1-980207
 * @since   1.0
 */
class TestWorkflowEvents extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'Test Workflow Events';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'test_workflow_events';
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
            [['id'], 'required'],
            [['id', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['title', 'workflow_status'], 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
                'id'              => 'ID',
                'title'           => 'Title',
                'workflow_status' => 'Workflow Status',
                'status'          => 'Status',
                'created_by'      => 'Created By',
                'created_at'      => 'Created At',
                'updated_by'      => 'Updated By',
                'updated_at'      => 'Updated At',
            ];
    }

    /**
     * {@inheritdoc}
     * @return TestWorkflowEventsQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery
    {
        return new TestWorkflowEventsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        //Facilitate reading workflow definitions from demo section
        Yii::setAlias('@workflowDefinitionNamespace', 'khans\\utils\\demos\\data');

        return array_merge([
            'Workflow' => [
                'class'                  => '\khans\utils\behaviors\WorkflowBehavior',
                'statusAttribute'        => 'workflow_status',
                'propagateErrorsToModel' => true,
                'autoInsert'             => false,
                'defaultWorkflowId'      => 'WF',
            ],
        ], parent::behaviors());
    }
}
