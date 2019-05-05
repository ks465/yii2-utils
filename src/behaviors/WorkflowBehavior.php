<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/01/19
 * Time: 18:59
 */


namespace khans\utils\behaviors;

use khans\utils\components\ArrayHelper;
use khans\utils\models\KHanModel;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use raoul2000\workflow\base\WorkflowException;
use raoul2000\workflow\events\WorkflowEvent;
use raoul2000\workflow\validation\WorkflowValidator;
use Yii;
use yii\db\Exception;
use yii\validators\Validator;

/**
 * Class WorkflowBehavior adds extra methods to SimpleWorkflowBehavior and concentrates all of methods in the
 * workflow behavior.
 *
 * @package khans\utils\widgets
 * @version 0.2.0-980212
 * @since   1.0.0
 *
 * @property string $defaultWorkflowId
 */
class WorkflowBehavior extends \raoul2000\workflow\base\SimpleWorkflowBehavior
{
    const STATUS_TABLE = 'sw_status';

    /**
     * @var KHanModel|null the owner of this behavior
     */
    public $owner;

    /**
     * Define interesting events AND add validator to check possible transitions.
     *
     * @return array
     */
    public function events(): array
    {
        // a suitable place to add the rule
        $validators = $this->owner->getValidators();
        $validators[] = Validator::createValidator(WorkflowValidator::class, $this->owner, $this->statusAttribute, [
            'message' => 'This message will NOT show up {attribute} => {value}',
        ]);

        return parent::events() + [
                SimpleWorkflowBehavior::EVENT_AFTER_CHANGE_STATUS => 'flowAfterChange',
            ];
    }

    private function doSomething($text, $id)
    {
        $recordId = $this->owner->getPrimaryKey();
        if (empty($recordId)) {
            return;
        }
        $data = [
            'responsible_model'   => $this->owner->tableName(),
            'responsible_record'  => $recordId,
            'timestamp'           => null, //the mail is not sent yet
            'content'             => $text,
            'recipient_email'     => 'student@khan.org',
            'cc_receivers'        => 'faculty@khan.org,department@khan.org',
            'attachments'         => null,
            'workflow_transition' => $id,
            'user'                => Yii::$app->user->id,
        ];
        $connection = Yii::$app->get('test')->createCommand();
        $connection->insert('sys_history_emails', $data)->execute();

        //todo: run a customized event handler set in the owner model
    }

    public function flowAfterChange(WorkflowEvent $event)
    {
        //currently critical one
        $result = $this->shouldSendEmail($event);

        if (is_null($event->getStartStatus()) and $result === false) {
            $this->doSomething('flowAfterChange (Null Start Status)', 'N/A');

            return true;
        }
        $result = $result ? $result : 'EMail will not be sent';
        if (is_null($event->getTransition())) {
            $this->doSomething('flowAfterChange::' . $result, 'NULL Transition');

            return true;
        }
        $this->doSomething('flowAfterChange::' . $result, $event->getTransition()->getId());

        //todo: run a customized event handler set in the owner model

        return true;
    }

    /**
     * Check the metadata of the end state of transition and returns the value of email config.
     * If the value is missing, `false` is the default.
     * If the argument is omitted --which means it is called by the model itself-- then the setting for
     * current status is returned.
     *
     * @param null|WorkflowEvent $event
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function shouldSendEmail(WorkflowEvent $event = null)
    {
        if (is_null($event)) {
            return $this->getWorkflowStatus()->getMetadata('email', false);
        }

        return $event->getEndStatus()->getMetadata('email', false);
    }

    /**
     * Get the label for the workflow of the current record.
     * This is mostly used for view pages
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->getWorkflowStatus()->getLabel() . ' <small class="text-info">(' . $this->owner->{$this->statusAttribute} . ')</small>';
    }

    /**
     * Prepare an associative array containing all the statuses. This is ideal for drop downs.
     * This method is designed for valid model records already in a workflow.
     *
     * @return array [status_id => status_label]
     * @see readStatusesFromTable
     */
    public function getStatusesLabels()
    {
        if (empty($this->getWorkflow())) {
            try {
                return static::readStatusesFromTable($this->getDefaultWorkflowId());
            } catch (Exception $e) {
            }
            $this->owner->enterWorkflow($this->getDefaultWorkflowId());
        }
        $list = [];
        try {
            foreach ($this->getWorkflow()->getAllStatuses() as $key => $status) {
                /* @var \raoul2000\workflow\base\Status $status */
                $list[$key] = $status->getLabel();
            }
        } catch (WorkflowException $e) {
            return ['' => $e->getMessage()];
        }

        return $list;
    }

    /**
     * Read list of statuses for this model directly from database.
     * This method is designed for situations which a valid model record in a workflow does not exist,
     * and list of statuses labels is required --like creating an active record.
     *
     * @param string $workflowID workflow ID for the requested list
     *
     * @return array [status_id => status_label]
     * @throws Exception
     * @see getStatusesLabels
     *
     */
    public static function readStatusesFromTable($workflowID)
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('tableName');

        return ArrayHelper::map(
            \Yii::$app->db->createCommand('SELECT `id`, `label` FROM `' . static::STATUS_TABLE . '` WHERE `workflow_id` = :W ORDER BY `sort_order`;',
                [':W' => $workflowID])->queryAll(), 'id', 'label');
    }
}
