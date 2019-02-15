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
use khans\utils\models\KHanModel;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Show column in grid views for data engaged in relations.
 * The following example shows `parent_id` a column from a relating table which references `id` in the
 * ParentModel table. In the target table `title` is the field acting as title. The following setup,
 * renders a column with Select2 filter searching for strings from `ParentModel`.`title` and showing the same
 * value as cell contents. Example:
 *
 * ```php
 *[
 *   'class'       => '\khans\utils\columns\RelatedColumn',
 *   'width'       => '200px',
 *   'attribute'   => 'parent_id', // in the child table
 *   'targetModel' => '\namespace\ParentModel',
 *   'titleField'  => 'title', // in the parent table
 *    'value'      => function($model) {
 *       return \yii\helpers\Html::a($model->parent->title . '<i class="fa fa-external-link"></i>',
 *          ['/module/parent/view', 'id' => $model->parent_id],
 *          ['data-pjax' => 0, 'role' => '']
 *       );
 *    },
 *    'group'      => true,
 *],
 * ...
 * ```
 *
 * Please note that the relation in the child table is called `parent`
 *
 * ```php
 * public function getTable()
 * {
 *      return $this->hasOne(ParentModel::class, ['id' => 'parent_id']);
 * }
 * ```
 *
 * @package common\widgets
 * @version 0.1.2-971126
 * @since   1.0
 */
class RelatedColumn extends DataColumn
{
    /**
     * @var Model|KHanModel FQN to a model containing the data
     */
    public $targetModel = '';
    /**
     * @var string name of the field in the container table which acts as the row title
     */
    public $titleField;
    /**
     * @var array|string URL of the action responsible for filtering the list. Defaults to `parents`
     */
    public $searchUrl = 'parents';

    /**
     * Setup the widget
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->targetModel)) {
            throw new InvalidConfigException('نام جدول هدف الزامی است.');
        }

        if (empty($this->titleField)) {
            throw new InvalidConfigException('نام ستون عنوان جدول هدف الزامی است.');
        }

        if (is_string($this->searchUrl)) {
            $this->searchUrl = [$this->searchUrl];
        }

        $this->filterType = GridView::FILTER_SELECT2;
        $this->filterWidgetOptions = [
            'initValueText' => ArrayHelper::getValue(
                $this->targetModel::findOne(ArrayHelper::getValue($this->grid->filterModel, $this->attribute)),
                $this->titleField),
            'hideSearch'    => false,
            'theme'         => Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear'         => true,
                'dir'                => 'rtl',
                'minimumInputLength' => 3,
                'ajax'               => [
                    'url'      => Url::to($this->searchUrl),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            ],
        ];

        if (empty($this->value)) {
            $this->value = function($model) {
                if (isset($model->parent)) {
                    return $model->parent->{$this->titleField};
                }

                return $model->{$this->attribute};
            };
        }

        $this->format = 'raw';
        if (empty($this->hAlign)) {
            $this->hAlign = GridView::ALIGN_RIGHT;
        }
        if (empty($this->vAlign)) {
            $this->vAlign = GridView::ALIGN_MIDDLE;
        }
        if (empty($this->headerOptions)) {
            $this->headerOptions = ['style' => 'text-align: center;'];
        }
        if (empty($this->contentOptions)) {
            $this->contentOptions = ['class' => 'pars-wrap'];
        }
        if (empty($this->width)) {
            $this->width = '150px';
        }

        parent::init();
    }
}
