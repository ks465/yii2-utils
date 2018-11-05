<?php


namespace KHanS\Utils\widgets;

use johnitvn\ajaxcrud\CrudAsset;
use kartik\helpers\Html;
use kartik\widgets\Widget;
use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/**
 * Create a uniform grid view for controllers. This is the common parts for both normal and AJAX grids.
 *
 * @package common\widgets
 * @version 0.1.0
 * @since   1.0.0
 */
abstract class BaseGridView extends Widget
{
    /**
     * Shortcut for panel.heading option
     *
     * @var string
     */
    public $title = '';
    /**
     * Shrotcut for panel.footer
     *
     * @var string
     */
    public $footer = '';
    /**
     * Shortcut to options.id and ID of the grid view container
     *
     * @var string
     */
    public $id = 'datatable';

    /**
     * @var array settings for pagination
     */
    public $pager;
    public $striped;
    public $condensed;
    public $responsive;
    public $export;
    public $toggleData;
    public $resizableColumn;
    public $before = '';
    public $formatter;
    public $showPageSummary = false;
    public $showCreate = true;

    public $beforeHeader = [];

    public $dataProvider;
    public $filterModel;
    public $columns;
    public $rowOptions = null;
    /**
     * @var array settings for pagination
     */

    public $bulkAction = [];
    public $createAction = false;
    public $floatHeader = false;
    public $createLabel;
    /**
     * @var bool used for refreshing the grid in modal form. If true, the refresh button refreshes the modal grid
     */
    public $gridIsModal = false;
    /**
     * @var array settings for refresh button
     */
    public $refreshOptions = [];
    /**
     * @var bool use \yii\widgets\Pjax]]
     */
    protected $pjax = false;
    protected $createContent = '';
    protected $content = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->user->isGuest) {
            $this->showCreate = false;
        }
        if ($this->showCreate && $this->createAction !== false) {
            if (!is_array($this->createAction)) {
                $this->createAction = [$this->createAction];
            }
            $this->createContent = Html::a('<i class="glyphicon glyphicon-plus"></i>', $this->createAction, [
                'role'  => 'modal-remote',
                'title' => $this->createLabel,
                'class' => 'btn btn-default',
            ]);
        }
        $this->pager = Yii::$app->params['pager'];
        if ($this->dataProvider->totalCount <= 25) {
            $this->dataProvider->pagination = ['pageSize' => 25];
        }

        if (!empty($this->title)) {
            $this->title = '<div class="pull-left">' . '<i class="glyphicon glyphicon-list"></i>&nbsp;' . $this->title . '</div>';
        }

        $this->content = '{toggleData}' . $this->export . '{export}';
        if ($this->refreshOptions !== false) {
            $this->refreshOptions =
                Html::a('<i class="glyphicon glyphicon-refresh"></i>', Url::current(), [
                    'class' => 'btn btn-default', 'title' => 'بازخوانی داده‌ها با حفظ فیلترها',
                ]) .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to(['']), [
                    'class' => 'btn btn-danger', 'title' => 'بازخوانی صفحه و پاک نمودن فیلترها',
                ]);
        }
        $this->content = $this->createContent . $this->refreshOptions . $this->content;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo \kartik\grid\GridView::widget([
            'id'               => $this->id,
            'beforeHeader'     => $this->beforeHeader,
            'dataProvider'     => $this->dataProvider,
            'filterModel'      => $this->filterModel,
            'floatHeader'      => $this->floatHeader,
            'formatter'        => $this->formatter,
            'pager'            => $this->pager,
            'pjax'             => $this->pjax,
            'pjaxSettings'     => ['options' => ['id' => $this->id]],
            'columns'          => $this->columns,
            'toolbar'          => [
                [
                    'content' => $this->content,
                ],
            ],
            'showPageSummary'  => $this->showPageSummary,
            'rowOptions'       => $this->rowOptions,
            'striped'          => true,
            'condensed'        => true,
            'responsive'       => true,
            'export'           => false,
            'toggleData'       => false,
            'resizableColumns' => false,
            'panel'            => [
                'type'    => 'primary',
                'heading' => $this->title,
                'after'   => false,
                'before'  => $this->before,
                'footer'  => $this->footer,
            ],
        ]);
    }
}

/**
 * Create a uniform grid view for controllers
 *
 * @see     \kartik\grid\GridView
 *          Example:
 *          ```php
 *          common\widgets\GridView::widget([
 *          'dataProvider' => $dataProvider,
 *          'filterModel' => $searchModel,
 *          'export' => <instance_of_ExportMenu>,
 *          'columns' => require(__DIR__ . '/_columns.php'),
 *          'title' => false,
 *          'footer' => false,
 *          'rowOptions' => function ($model, $index, $widget, $grid) {
 *          if ($model->id % 2) // change to your needs
 *              return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
 *          return [];
 *          },
 *          ])
 *          ```
 * Because this requires a modal window, for simplicity it extends Widget and not GridView
 * @package common\widgets
 */
class GridView extends BaseGridView
{
    /**
     * @var array settings for refresh button
     */
    public $refreshOptions = ['class' => 'btn btn-default', 'title' => 'بازخوانی داده‌ها با حفظ فیلترها'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}

/**
 * Create a uniform grid view for Ajax controllers along with the required Modal widget required for this to work
 *
 * @see     \kartik\grid\GridView
 *          Example:
 *          ```php
 *          common\widgets\AjaxGridView::widget([
 *          'dataProvider' => $dataProvider,
 *          'filterModel' => $searchModel,
 * 'export' => instance_of_ExportMenu,
 *          'columns' => require(__DIR__ . '/_columns.php'),
 *          'createAction' => ['create', 'id' => $itemID],
 *          'createLabel' => 'Create New Item',
 *          'title' => false,
 *          'footer' => false,
 *          'gridIsModal' => true,
 *          'bulkAction' => [
 *          'action' => 'bulk-delete',
 *          'label' => 'Delete',
 *          'icon' => 'trash',
 *          'class' => 'danger',
 *          'message' => 'Some alert',
 *          ],
 *          ])
 *          ```
 * Because this requires a modal window, for simplicity it extends Widget and not GridView
 * @package common\widgets
 */
class AjaxGridView extends BaseGridView
{
    public $refreshOptions = ['class' => 'btn btn-default', 'title' => 'بازخوانی داده‌ها با حفظ فیلترها'];
    protected $pjax = true;

    public function init()
    {
        CrudAsset::register($this->getView());

        if ($this->gridIsModal) {
            $this->refreshOptions['role'] = 'modal-remote';
        }

        if (!empty($this->bulkAction) && is_array($this->bulkAction)) {
            $this->before .= BulkButtonWidget::widget([
                    'buttons' =>
                        Html::a('<i class="glyphicon glyphicon-' . $this->bulkAction['icon'] . '"></i>&nbsp;' . $this->bulkAction['label'],
                            [$this->bulkAction['action']],
                            [
                                "class"                => 'btn btn-' . $this->bulkAction['class'],
                                'role'                 => 'modal-remote-bulk',
                                'data-confirm'         => false,
                                'data-method'          => false,// for overide yii data api
                                'data-request-method'  => 'post',
                                'data-confirm-title'   => ' آیا اطمینان دارید؟',
                                'data-confirm-message' => $this->bulkAction['message'],
                            ]),
                ]) .
                '<div class="clearfix"></div>';
        }

        if (!empty($this->title)) {
            $this->title = '<div class="pull-left">' . '<i class="glyphicon glyphicon-list"></i>&nbsp;' . $this->title . '</div>';
        }

        $this->id .= '-pjax';

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        Modal::begin([
            "id"      => "ajaxCrudModal",
            "footer"  => "",// always need it for jquery plugin
            'options' => [
                'tabindex' => false // important for Select2 to work properly
            ],
        ]);
        Modal::end();
    }
}