<?php


namespace khans\utils\widgets;

use kartik\helpers\Html;
use kartik\icons\Icon;
use khans\utils\components\Jalali;
use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\i18n\Formatter;

/**
 * Create a uniform grid view for controllers. This is also the common parts for both normal and AJAX grids.
 *
 * @see     http://demos.krajee.com/grid
 * Example:
 * ```php
 * khans\utils\widgets\GridView::widget([
 *    'dataProvider' => $dataProvider,
 *    'filterModel' => $searchModel,
 *    'columns' => require(__DIR__ . '/_columns.php'),
 *    'title' => false,
 *    'footer' => false,
 *    'rowOptions' => function ($model, $index, $widget, $grid) {
 *       if ($model->id % 2) // change to your needs
 *           return ['class' => 'alert-danger', 'style' => 'background-color: #f2dede;'];
 *       return [];
 *    },
 * ])
 * ```
 * GridView 1.* and AjaxGridView 1.* are merged together, and there is no AjaxGridView in the 2.* version.
 * For details of bulkAction usage see [guide]
 *
 * @package khans\utils\widgets
 * @version 2.4.2-980128
 * @since   1.0
 */
class GridView extends \kartik\grid\GridView
{
    /**
     * Constant defining export menu uses default grid exporter
     */
    const EXPORTER_SIMPLE = 'grid';
    /**
     * Constant defining export menu uses [[ExportMenu]]
     */
    const EXPORTER_MENU = 'menu';

    /**
     * @var string Shortcut for panel.heading option
     */
    public $title = '';
    /**
     * @var string Shortcut for panel.footer
     */
    public $footer = '';
    /**
     * @var string Shortcut for panel.before
     */
    public $before = '';
    /**
     * @var string Shortcut for panel.after
     */
    public $after = '';
    /**
     * @var string Shortcut to options.id and ID of the grid view container
     */
    public $id = 'datatable';
    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of Formatter or an configuration array for creating the Formatter
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter = ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''];
    /**
     * @var array Configuration parameters to put a button in the panel to collect selected data in
     * CheckboxColumn and RadioColumn and call an action on all of them.
     *    + action is the URL to the target action,
     *    + label is the label of the created button
     *    + icon is tag of the glyphicon-* to use
     *    + class is the tag of the bootstrap btn-* class
     *    + message is the text of the message to show as confirmation of action.
     */
    public $bulkAction;
    /**
     * @var array|boolean Configuration parameters to put a button in the panel to trige createAction or equivalent.
     *    + action is the URL to the target action, default is create.
     *    + title is the text of the tooltip for created button
     *    + icon is tag of the glyphicon-* to use
     *    + class is the tag of the bootstrap btn-* class
     *    + ajax boolean if `true` which is default, `role => modal-remote` will be set, if it is false `role` is empty.
     * If this attribute is set to `true` the default settings will be enables.
     * If this attribute is set to `false` the button will not rendered.
     */
    public $createAction;
    /**
     * @var boolean Defaults to `true`. The entire GridView widget will be parsed via Pjax and auto-rendered
     * inside a yii\widgets\Pjax widget container. Individual actions can be disabled in
     *     [[\khans\utils\columns\ActionColumn]]
     */
    public $pjax = true;
    /**
     * @var bool used for refreshing the grid in modal form. If true, the refresh button refreshes the modal grid
     */
    public $gridIsModal = false;
    /**
     * @var boolean|string Content of refresh buttons in the panel. If set to `true` default buttons are shown, one
     *     preserving the filters, the other clear filters. If set to `false` --the default--, no button is shown. If
     *     it is string, it will appear in the table panel.
     */
    public $showRefreshButtons = false;
    /**
     * @var string Shortcut for panel.type option
     */
    public $type = 'primary';
    /**
     * @var null|string the grid export menu type. If set to `grid` default export menu of the GridView is used.
     *    If set to `menu` {{ExportMenu]] is activated.
     */
    public $export = null;
    /**
     * @var string Arbitrary string to appear in the panel.
     */
    protected $content = '';
    /**
     * @var array the modal size. Can be Modal::SIZE_LARGE or Modal::SIZE_SMALL, or empty for default.
     */
    private $_createAction = [
        'action' => 'create',
        'title'  => 'افزودن',
        'icon'   => 'plus',
        'class'  => 'btn btn-success btn-xs',
        'ajax'   => true,
    ];

    /**
     * Setup custom configuration
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        GridAsset::register($this->getView());
        Modal::begin([
            "id"      => "ajaxCrudModal",
            'size'    => Modal::SIZE_LARGE,
            "footer"  => "",// always need it for jquery plugin
            'options' => [
                "id"      => "ajaxCrudModal",
                'tabindex' => false, // important for Select2 to work properly
            ],
        ]);
        Modal::end();

        $this->pager = Yii::$app->params['pager'];

        $page = $this->dataProvider->getPagination();
        if (!empty($page)) {
            $page->pageParam = $this->id . '-page';
        }

        if (!empty($this->dataProvider->getSort())) {
            $this->dataProvider->getSort()->sortParam = $this->id . '-sort';
        }

        /** @noinspection PhpUndefinedFieldInspection */
        if ($this->dataProvider->totalCount <= 25) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->dataProvider->pagination = ['pageSize' => 25];
        }

        if (empty($this->title) and $this->title !== false) {
            $this->title = $this->getView()->title;
        }

        switch ($this->export) {
            case self::EXPORTER_SIMPLE:
                $this->loadExportSegment();
                $exporter = '';
                break;
            case self::EXPORTER_MENU:
                $exporterDP = clone $this->dataProvider;
                $exporterDP->pagination = false;
                $exporter = ExportMenu::widget([
                    'dataProvider' => $exporterDP,
                ]);
                $this->export = false;
                break;
            default:
                $exporter = $this->export;
                $this->export = false;
        }

        if ($this->showRefreshButtons === true) {
            $this->showRefreshButtons =
                Html::a('<i class="glyphicon glyphicon-refresh"></i>', Url::current(), [
                    'class' => 'btn btn-default', 'title' => 'بازخوانی داده‌ها با حفظ فیلترها',
                ]) .
                // Ensure the grid is reloaded correctly even in a parent_view::child_grid. Add the actionParams, even if most of the time it is not required
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to([''] + Yii::$app->requestedAction->controller->actionParams), [
                    'class' => 'btn btn-danger', 'title' => 'بازخوانی صفحه و پاک نمودن فیلترها',
                ]);
        }
        $this->toolbar['content'] = $this->showRefreshButtons . $exporter . $this->content;
        $this->pjaxSettings['options']['id'] = $this->id;

        if ($this->panel !== false) {
            $this->panel['heading'] = '<div class="pull-left">' . '<i class="glyphicon glyphicon-list"></i>&nbsp;' . $this->title . '</div>';
            $this->panel['type'] = $this->type;
            $this->panel['before'] = $this->before;
            $this->panel['after'] = $this->after;
            $this->panel['footer'] = $this->footer;
        } else {
            $this->panelHeadingTemplate = '';
            $this->panel['before'] = false;
            $this->panel['after'] = false;
        }

        $this->resizableColumns = false;
        $this->toggleData = false;
        $this->striped = true;
        $this->condensed = true;
        $this->responsive = true;

        if (!empty($this->bulkAction)) {
            if (isset($this->bulkAction['dropdown']) and $this->bulkAction['dropdown']) {
                $this->loadBulkSegmentDropdown();
            } else {
                $this->loadBulkSegmentButton();
            }
        }

        if (!empty($this->createAction) && $this->createAction !== false) {
            if(isset($this->columns['action']['controller'])){
                $this->_createAction['action'] = $this->columns['action']['controller'] . '/' . $this->_createAction['action'];
            }
            if ($this->createAction === true) {
                $this->createAction = $this->_createAction;
            } else {
                $this->createAction = array_merge($this->_createAction, $this->createAction);
            }

            $this->toolbar['content'] .= Html::a('<i class="glyphicon glyphicon-' . $this->createAction['icon'] . '"></i>',
                [$this->createAction['action']],
                [
                    'role'  => $this->createAction['ajax'] === true ? 'modal-remote' : '',
                    'title' => $this->createAction['title'], 'class' => 'btn btn-success',
                ]);
        }

        parent::init();
    }

    /**
     * If export component of the grid is active load and place it.
     */
    private function loadExportSegment()
    {
        Icon::map($this->getView(), Icon::FA); //required for font awesome
        if ($this->export === true or $this->export === GridView::EXPORTER_SIMPLE) {
            $this->export = [
                'icon'        => 'download',
                'fontAwesome' => true,
                'options'     => [
                    'class' => 'btn btn-info',
                    'title' => 'دریافت داده‌های نمایش داده شده در صفحه به صورت فایل',
                ],
                'header'      => '<li role="presentation" class="dropdown-header">دریافت داده‌های صفحه</li>',
                'messages'    => [
                    'allowPopups'      => 'مرورگر شما می‌بایست برای باز شدن پنجره‌های دیگر (Popups) مجاز باشد.',
                    'confirmDownload'  => 'آیا ساخت فایل برای دریافت آغاز گردد؟',
                    'downloadProgress' => 'در حال ساخت و دریافت فایل ...',
                    'downloadComplete' => 'دریافت فایل به پایان رسید.',
                ],
            ];
        }
        $this->export['icon'] = 'fa fa-' . $this->export['icon'];

        $filename = str_replace(' ', '_', $this->title . '_' . Jalali::date(Jalali::KHAN_SHORT));
        $this->exportConfig = [
            GridView::PDF => [
                'label'    => 'دریافت پی‌دی‌اف',
                'alertMsg' => 'يک فایل PDF برای دریافت آماده خواهد شد.',
                'filename' => $filename,
            ],
            GridView::CSV => [
                'label'    => 'دریافت برای اکسل',
                'alertMsg' => 'يک فایل CSV برای دریافت آماده خواهد شد.',
                'filename' => $filename,
            ],
        ];
    }

    /**
     * If more than one bulk actions are requested, configure them in a way similar to DropdownX
     */
    private function loadBulkSegmentDropdown()
    {
        if (empty($this->bulkAction['class'])) {
            $this->bulkAction['class'] = 'default';
        }
        if (empty($this->bulkAction['icon'])) {
            $this->bulkAction['icon'] = 'glyphicon-cog';
        }
        if (empty($this->bulkAction['message'])) {
            $this->bulkAction['message'] = 'از انجام این دستور اطمینان دارید؟';
        }
        if (empty($this->bulkAction['hint'])) {
            $this->bulkAction['hint'] = 'با همه انتخاب شده‌ها';
        }
        if (empty($this->bulkAction['label'])) {
            $this->bulkAction['label'] = '';
        }

        $this->panel['before'] .= '<div class="pull-left rtl">' .
            '&nbsp;&nbsp;' . $this->bulkAction['hint'] . '&nbsp;&nbsp;<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;' .
            '<div class="btn-group">' .
            '<button data-toggle="dropdown" class="dropdown-toggle btn btn-default" title="نمایش دستورات">' .
            '<i class="glyphicon ' . $this->bulkAction['icon'] . '"></i>' .
            '&nbsp;' . $this->bulkAction['label'] . '&nbsp;' . '&nbsp;' .
            '<b class="caret"></b>' .
            '</button>' .
            $this->bulkAction['action'] .
            '</div>' .
            '</div>';
    }

    /**
     * If bulk action button is requested, configure it and add it to the panel.
     */
    private function loadBulkSegmentButton()
    {
        if (empty($this->bulkAction['class'])) {
            $this->bulkAction['class'] = 'default';
        }
        if (empty($this->bulkAction['message'])) {
            $this->bulkAction['message'] = 'از انجام این دستور اطمینان دارید؟';
        }
        if (empty($this->bulkAction['hint'])) {
            $this->bulkAction['hint'] = 'با همه انتخاب شده‌ها';
        }

        $this->panel['before'] .= '<div class="pull-left rtl">' .
            '&nbsp;&nbsp;' . $this->bulkAction['hint'] . '&nbsp;&nbsp;<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;' .
            Html::a('<i class="glyphicon glyphicon-' . $this->bulkAction['icon'] . '"></i>&nbsp;' . $this->bulkAction['label'],
                [$this->bulkAction['action']],
                [
                    'class'                => 'btn btn-' . $this->bulkAction['class'],
                    'role'                 => 'modal-remote-bulk',
                    'data-confirm'         => false, // for override default confirmation
                    'data-method'          => false, // for override yii data api
                    'data-request-method'  => 'post',
                    'data-confirm-title'   => ' آیا اطمینان دارید؟',
                    'data-confirm-message' => $this->bulkAction['message'],
                ]) .
            '</div>';
    }
}
