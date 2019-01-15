<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/20/16
 * Time: 5:13 PM
 */


namespace khans\utils\columns;


use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use khans\utils\behaviors\WorkflowBehavior;
use khans\utils\models\KHanModel;
use yii\db\Exception;

/**
 * Show column in grid views for progress status (workflow) field of the data along with required filter element
 * Example:
 * ```php
 *[
 *   'class' => 'khans\utils\columns\ProgressColumn',
 *   'attribute'  => 'progress_column',
 *   'workflowID' => 'TestWF',
 *],
 * ```
 *
 * @package khans\utils
 * @version 0.2.0-971021
 * @since   1.0
 */
class ProgressColumn extends DataColumn
{
    public $workflowID;

    /**
     * Setup filter and value tuned for models containing WorkflowBehavior.
     * If [[workflowID]] is not set, no filter would be rendered.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        try {
            $filterList = WorkflowBehavior::readStatusesFromTable($this->workflowID);
        } catch (Exception $e) {
            $filterList = [];
        }

        if (count($filterList) > 1) {
            $this->filterType = GridView::FILTER_SELECT2;
            $this->filterWidgetOptions = [
                'initValueText' => '',
                'hideSearch'    => false,
                'theme'         => Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dir'        => 'rtl',
                ],
            ];
            $this->filter = ['' => ''] + $filterList;
        } else {
            $this->mergeHeader = true;
        }

        if (empty($this->attribute)) {
            $this->attribute = 'progress_status';
        }

        if (empty($this->value)) {
            $this->value = function(KHanModel $model) {
                return $model->getWorkflowStatus()->getLabel();
            };
        }

        $this->hAlign = GridView::ALIGN_RIGHT;
        $this->vAlign = GridView::ALIGN_MIDDLE;
        $this->headerOptions = ['style' => 'text-align: center;'];

        parent::init();
    }
}
