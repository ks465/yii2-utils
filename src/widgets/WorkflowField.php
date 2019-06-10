<?php


/**
 * Created by PhpStorm. User: keyhan Date: 11/01/19 Time: 16:02
 */
namespace khans\utils\widgets;

use khans\utils\models\KHanModel;

/**
 * Class WorkflowField renders a [[Select2]] input element for fields engaged in a workflow status of a model. This
 * class mainly sets a few required config in a [[Select2]]
 *
 * @package khans\utils\widgets
 * @version 0.3.1-980316
 * @since 1.0.0
 */
class WorkflowField extends \kartik\select2\Select2
{
    /**
     *
     * @var KHanModel model containing the workflow and field
     */
//     public $model;

    // todo: prepare selection for input field and view element
    public function init()
    {
        $dropDownData = \raoul2000\workflow\helpers\WorkflowHelper::getStatusDropDownData($this->model);

        $this->theme = self::THEME_BOOTSTRAP;
        $this->data = ['' => ''] + $dropDownData['items'];
        $this->options = ['options' => $dropDownData['options']];
        $this->pluginOptions['dir'] = 'rtl';

        parent::init();
    }
}
