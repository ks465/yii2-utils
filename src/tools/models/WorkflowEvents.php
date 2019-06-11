<?php


namespace khans\utils\tools\models;

use Yii;


/**
 * This is the model class for viewing the workflow definitions.
 * It uses table "test_workflow_events" as an anchor.
 *
 * @property string $tableComment View Workflow Objects
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
 * @version 0.1.0-980221
 * @since   1.0
 */
class WorkflowEvents extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'View Workflow Objects';


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
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'Workflow' => [
                'class'                  => '\khans\utils\components\workflow\WorkflowBehavior',
                'statusAttribute'        => 'workflow_status',
                'propagateErrorsToModel' => true,
                'autoInsert'             => false,
            ],
        ];
    }
}
