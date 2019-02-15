<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/01/19
 * Time: 16:02
 */


namespace khans\utils\widgets;


use khans\utils\models\KHanModel;

/**
 * Class WorkflowField renders a [[Select2]] input element for fields engaged in a workflow status of a model.
 * This class mainly sets a few required config in a [[Select2]]
 *
 * @package khans\utils\widgets
 * @version 0.2.0-971021
 * @since   1.0.0
 */
class WorkflowField extends \kartik\select2\Select2
{
    /**
     * @var KHanModel model containing the workflow and field
     */
    public $model;
//todo: prepare selection for input field and view element
    public function init()
    {
        $this->theme = self::THEME_BOOTSTRAP;
        $this->data = ['' => ''] + $this->model->getStatusesLabels();
        $this->pluginOptions['dir'] = 'rtl';

        parent::init();
    }
}
