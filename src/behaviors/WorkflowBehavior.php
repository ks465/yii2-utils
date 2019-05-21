<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/01/19
 * Time: 18:59
 */

namespace khans\utils\behaviors;

use raoul2000\workflow\base\SimpleWorkflowBehavior;
use raoul2000\workflow\base\WorkflowException;
use raoul2000\workflow\events\WorkflowEvent;
use raoul2000\workflow\validation\WorkflowValidator;
use Yii;
use yii\validators\Validator;
use khans\utils\components\workflow\KHanWorkflowHelper;

/**
 * Class WorkflowBehavior adds extra methods to SimpleWorkflowBehavior and concentrates all of methods in the
 * workflow behavior.
 *
 * @package khans\utils\widgets
 * @version 0.3.2-980219
 * @since   1.0
 *
 * @property string $defaultWorkflowId
 */
class WorkflowBehavior extends \raoul2000\workflow\base\SimpleWorkflowBehavior
{
//    const STATUS_TABLE = 'sw_status';

    /**
     * @var KHanModel|null the owner of this behavior
     */
    public $owner;
    /**
     *
     * @var
     */
    public $emailAction;
//     /**
//      * @var string Value to use when the email setting of the workflow status is `TRUE` instead of text template
//      */
//     public $defaultEmailText = 'وضعیت تغییر نموده است. پورتال خود را ببینید.';
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
//                SimpleWorkflowBehavior::EVENT_BEFORE_CHANGE_STATUS=> 'flowAfterChange',// kept for testing purpose only
                SimpleWorkflowBehavior::EVENT_AFTER_CHANGE_STATUS => 'flowAfterChange',
            ];
    }

    private function doSomething($text, $transitionID)
    {
//Yii::$app->session->addFlash('info', $text);
        $recordId = $this->owner->getPrimaryKey();
        if (empty($recordId)) {
            return;
        }

        if($this->owner->hasMethod('getFullAttributes')){
            //if the owner model has EAV behavior check for them too
            foreach ($this->owner->getFullAttributes() as $attr => $value){
                $text = str_replace('{' . $attr . '}', $value, $text);
//Yii::$app->session->addFlash('warning', $value);
//Yii::$app->session->addFlash('error', ($value ?? '--'));
            }
//Yii::$app->session->addFlash('info', 11 . $text);
        }else{
            foreach ($this->owner->attributes as $attr => $value){
                $text = str_replace('{' . $attr . '}', $value , $text);
            }
//Yii::$app->session->addFlash('info', 12 . $text);
        }

        $data = [
            'responsible_model'   => $this->owner->tableName(),
            'responsible_record'  => $recordId,
            'enqueue_timestamp'   => time(),
            'content'             => $text,
            'recipient_email'     => 'student@khan.org',
            'cc_receivers'        => 'faculty@khan.org,department@khan.org',
            'attachments'         => null,
            'workflow_transition' => $transitionID,
            'user'                => Yii::$app->user->id,
        ];

        $connection = Yii::$app->get('test')->createCommand();
        $connection->insert('sys_history_emails', $data)->execute();

        //todo: run a customized event handler set in the owner model
    }

    public function flowAfterChange(WorkflowEvent $event)
    {
        //currently critical one
        $sendEmail = $this->shouldSendEmail($event);
// vdd($result);
        if ($sendEmail === false) {
            $this->doSomething('EMail will not be sent', 'N/A');
//Yii::$app->session->addFlash('info', 0);
            return true;
        }
        if (is_null($event->getStartStatus())) {
            $this->doSomething('flowAfterChange (Null Start Status)', 'N/A');
//Yii::$app->session->addFlash('info', 1);
            return true;
        }
        if (is_null($event->getTransition())) {
            $this->doSomething('flowAfterChange::' . $sendEmail, 'NULL Transition');
//Yii::$app->session->addFlash('info', 2);
            return true;
        }
//         if($sendEmail === true){
//             $sendEmail = $this->defaultEmailText;
//         }
        $this->doSomething(KHanWorkflowHelper::getEmailTemplate($status), $event->getTransition()->getId());

        //todo: run a customized event handler set in the owner model
//Yii::$app->session->addFlash('info', 3);
        return true;
    }

    /**
     * Check the metadata of the workflow and the end state of transition and returns the value of email config.
     * If the value is missing, `false` is the default.
     *
     * @param null|WorkflowEvent $event
     *
     * @return boolean
     * @throws \yii\base\InvalidConfigException
     */
    public function shouldSendEmail(WorkflowEvent $event = null)
    {
        if (is_null($event)) {
            $status = $this->getWorkflowStatus();
//             return $this->getWorkflowStatus()->getMetadata('email', false);
        }else{
            $status = $event->getEndStatus();
        }

        return KHanWorkflowHelper::shouldSendEmail($status);
//         if (is_null($status->getWorkflow()->getMetadata('email'))) {
//             return FALSE;
//         }

//         return $status->getMetadata('email', false);
// //         return $event->getEndStatus()->getMetadata('email', false);
    }

    /**
     * Check the metadata of the current state of transition and returns the actor role for that.
     * If the value is missing, `null` is the default.
     *
     * @return null|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getActor()
    {
        return $this->getWorkflowStatus()->getMetadata('actor', null);
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
//            try {
//                return static::readStatusesFromTable($this->getDefaultWorkflowId());
//            } catch (Exception $e) {
//            }
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

//    /**
//     * Read list of statuses for this model directly from database.
//     * This method is designed for situations which a valid model record in a workflow does not exist,
//     * and list of statuses labels is required --like creating an active record.
//     *
//     * @param string $workflowID workflow ID for the requested list
//     *
//     * @return array [status_id => status_label]
//     * @throws Exception
//     * @see WorkflowBehavior::getStatusesLabels
//     *
//     */
//    public static function readStatusesFromTable($workflowID)
//    {
//        $tableSchema = Yii::$app->db->schema->getTableSchema('tableName');
//
//        return ArrayHelper::map(
//            \Yii::$app->db->createCommand('SELECT `id`, `label` FROM `' . static::STATUS_TABLE . '` WHERE `workflow_id` = :W ORDER BY `sort_order`;',
//                [':W' => $workflowID])->queryAll(), 'id', 'label');
//    }
}
