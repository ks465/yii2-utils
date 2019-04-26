<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/01/19
 * Time: 18:59
 */


namespace khans\utils\behaviors;

use khans\utils\components\ArrayHelper;
use raoul2000\workflow\base\WorkflowException;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Class WorkflowBehavior adds extra methods to SimpleWorkflowBehavior and concentrates all of methods in the
 * workflow behavior.
 *
 * @package khans\utils\widgets
 * @version 0.1.0-971021
 * @since   1.0.0
 */
class WorkflowBehavior extends \raoul2000\workflow\base\SimpleWorkflowBehavior
{
    /**
     * @var string name of the table containing definitions for workflow statuses
     */
    const STATUS_TABLE = 'sw_status';
    /**
     * @var string ID of the planned workflow for this table
     */
//    public $workflowID;
    public $defaultWorkflowId;

//    /**
//     * Ensure the workflow ID is set. This is forced in order to use it in various parts of code,
//     * and avoid complex coding.
//     *
//     * @throws InvalidConfigException
//     */
//    public function init()
//    {
//        if (empty($this->workflowID)) {
//            $this->workflowID = $this->getDefaultWorkflowId();
//        }
//        parent::init();
//    }

    /**
     * Get the label for the workflow of the current record.
     * This is mostly used for view pages
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->getWorkflowStatus()->getLabel() . ' (' . $this->owner->{$this->statusAttribute} . ')';
    }

    /**
     * Prepare an associative array containing all the statuses. This is ideal for drop downs.
     * This method is designed for valid model records already in a workflow.
     *
     * @see readStatusesFromTable
     * @return array [status_id => status_label]
     */
    public function getStatusesLabels()
    {
        if (empty($this->getWorkflow())) {
            try {
                return static::readStatusesFromTable($this->workflowID);
            } catch (Exception $e) {
                return ['' => $e->getMessage()];
            }
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
     * @see getStatusesLabels
     *
     * @param string $workflowID workflow ID for the requested list
     *
     * @return array [status_id => status_label]
     * @throws Exception
     */
    public static function readStatusesFromTable($workflowID)
    {
        return ArrayHelper::map(
            \Yii::$app->db->createCommand('SELECT `id`, `label` FROM `' . static::STATUS_TABLE . '` WHERE `workflow_id` = :W ORDER BY `sort_order`;',
                [':W' => $workflowID])->queryAll(), 'id', 'label');
    }
}
