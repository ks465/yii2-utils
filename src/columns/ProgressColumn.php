<?php


/**
 * Created by PhpStorm. User: keyhan Date: 7/20/16 Time: 5:13 PM
 */
namespace khans\utils\columns;

use kartik\grid\GridView;
use kartik\select2\Select2;
use khans\utils\components\workflow\WorkflowBehavior;
use khans\utils\models\KHanModel;
use raoul2000\workflow\helpers\WorkflowHelper;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Show column in grid views for progress status (workflow) field of the data along with required filter element
 * Example:
 *
 * ```php
 * ['class' => 'khans\utils\columns\ProgressColumn', 'attribute' => 'progress_column', ],
 * ```
 *
 * @package khans\utils
 * @version 0.5.2-980321
 * @since 1.0
 */
class ProgressColumn extends DataColumn
{
    /**
     *
     * @var string ID of the workflow
     */
    private $workflowID;

    /**
     *
     * @var boolean if the workflow source is a unique one, or there are multiple sources used for different records
     */
    public $mixedDefinitions = false;

    /**
     * Setup filter and value tuned for models containing WorkflowBehavior.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->mixedDefinitions) {
            /* @var KHanModel $model */
            $model = new $this->grid->filterModel->query->modelClass();
            $model->enterWorkflow(null);
            $this->workflowID = $model->getWorkflow()->getId();
            // try {
            // $filterList = WorkflowBehavior::readStatusesFromTable($this->workflowID);
            // } catch (Exception $e) {
            // if($e->getCode() == 42){//Base table or view not found
            // /** @noinspection PhpParamsInspection */
            $filterList = WorkflowHelper::getAllStatusListData($this->workflowID, $model->getWorkflowSource());
            // }else{
            // $filterList = [];
            // }
            // }

            if (count($filterList) > 1) {
                $this->filterType = GridView::FILTER_SELECT2;
                $this->filterWidgetOptions = [
                    'initValueText' => '',
                    'hideSearch' => false,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => ['allowClear' => true, 'dir' => 'rtl',],
                ];
                $this->filter = ['' => ''] + $filterList;
            } else {
                $this->mergeHeader = true;
            }
        }

        if (empty($this->attribute)) {
            $this->attribute = 'progress_status';
        }

        if (empty($this->value)) {
            $this->value = function (KHanModel $model) {
                return $model->getWorkflowStatus()->getLabel();
            };
        }

        if (empty($this->hAlign)) {
            $this->hAlign = GridView::ALIGN_RIGHT;
        }
        if (empty($this->vAlign)) {
            $this->vAlign = GridView::ALIGN_MIDDLE;
        }

        parent::init();
    }
}
