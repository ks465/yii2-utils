<?php


namespace khans\utils\components\workflow;

use yii\helpers\Html;
use khans\utils\components\workflow\KHanWorkflowHelper;

/**
 * Class WorkflowButtonsrenders a button group for all defined transitions Add the following to a view file: ```php echo
 * \khans\utils\components\workflow\WorkflowButtons::widget([ 'model' => $model, 'name' => 'name-attribute-of
 * the-button', ]); ```
 *
 * @package KHanS\Utils
 * @version 0.1.1-980330
 * @since 1.0
 */
class WorkflowButtons extends \yii\bootstrap\ButtonGroup
{
    /**
     * A string used for name tag of the generated buttons. This is used in posted data.
     *
     * @var string
     */
    public $name = 'wf-buttons';

    /**
     * A model with WorkflowBehavior.
     */
    public $model;

    /**
     * Build and configure the buttons
     */
    public function init()
    {
        $this->encodeLabels = false;

        $this->buttons = [];
        foreach ($this->model->getNextStatuses() as $status => $data) {
            $status = str_replace($data['status']->getWorkflowId() . '/', '', $status);
            $data = $data['status'];
            $this->buttons[] = [
                'label' => '<i class="glyphicon glyphicon-' . $data->getMetadata('icon') . '"></i> ' . $data->getLabel(),
                'visible' => KHanWorkflowHelper::getAllowedStatusesByRole($data),
                'options' => [
                    'class' => 'btn btn-block btn-' . $data->getMetadata('class'),
                    'title' => $data->getMetadata('description'),
                    'type' => 'submit',
                    'name' => $this->name,
                    'value' => $status,
                ],
            ];
        }

        parent::init();
    }
}
