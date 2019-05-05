<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/23/16
 * Time: 5:19 PM
 */


namespace khans\utils\columns;

use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use khans\utils\components\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Show column in grid views for data engaged in relations. This column is used in child views.
 * The following example shows `parent_id` a column from a relating table which references `id` in
 * the ParentModel table. In the target table `title` is the field acting as title. The following setup, renders a
 * column with Select2 filter searching for strings from `ParentModel`.`title` and showing the same value as cell
 * contents. Example:
 *
 * ```php
 *[
 *   'class'            => '\khans\utils\columns\RelatedColumn',
 *   'attribute'        => 'parent_id', // in the child table,
 *   'parentController' => 'module/controller-path',
 *   'showParentModal'  => true,
 *],
 * ...
 * ```
 *
 * Please note that the relation in the child table should use [PrentChildTrait], and the controller should extend
 * [KHanWebController].
 *
 * @package common\widgets
 * @version 0.2.1-980207
 * @since   1.0
 */
class RelatedColumn extends DataColumn
{
    /**
     * @var string Path to the controller responsible for parent. The view method of this controller is used.
     */
    public $parentController = '';
    /**
     * @var bool Show the parent view page in modal or in a separate way.
     */
    public $showParentModal = false;

    /**
     * Setup the widget
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->showParentModal === true) {
            //todo: show parent as model when the design for parent is not modal
//            $this->showParentModal = 'modal-remote';
        }
        if (empty($this->value)) {
            $this->value = function($model) {
                if (isset($model->parent)) {
                    $pks = $model->parent::primaryKey();
                    if (count($pks) == 1) {
                        $pks = ['id'];
                    }

                    return $model->parentTitle . Html::a(' <i class="glyphicon glyphicon-link"></i>',
                            [$this->parentController . '/view'] +
                            array_combine($pks, ArrayHelper::filter($model->attributes, $model->linkFields)
                            ),
                            ['data-pjax' => 0, 'role' => $this->showParentModal]
                        );
                }

                return $model->{$this->attribute};
            };
        }

        if (!empty($this->grid->filterModel)) {
            $parentTable = $this->grid->filterModel->parentTable;

            $this->filterType = GridView::FILTER_SELECT2;
            $this->filterWidgetOptions = [
                'initValueText' => ArrayHelper::getValue($parentTable::findOne(
                    ArrayHelper::getValue($this->grid->filterModel, $this->attribute, 0)
                ), $parentTable::getTitleField()),
                'hideSearch'    => false,
                'theme'         => Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear'         => true,
                    'dir'                => 'rtl',
                    'minimumInputLength' => 3,
                    'ajax'               => [
                        'url'      => Url::to(['parents-list']),
                        'dataType' => 'json',
                        'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                ],
            ];
        }
        if (empty($this->hAlign)) {
            $this->hAlign = GridView::ALIGN_RIGHT;
        }
        if (empty($this->vAlign)) {
            $this->vAlign = GridView::ALIGN_MIDDLE;
        }
        if (empty($this->headerOptions)) {
            $this->headerOptions = ['style' => 'text-align: center;'];
        }
        $this->format = 'raw';
        $this->group = true;
        parent::init();
    }
}
