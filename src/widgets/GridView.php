<?php


namespace KHanS\Utils\widgets;

use kartik\helpers\Html;
use kartik\icons\Icon;
use KHanS\Utils\components\Jalali;
use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\i18n\Formatter;

/**
 * Create a uniform grid view for controllers. This is also the common parts for both normal and AJAX grids.
 *
 * @see     http://demos.krajee.com/grid
 * Example:
 *
 * ```php
 * KHanS\Utils\widgets\GridView::widget([
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
 *
 * @package KHanS\Utils\widgets
 * @version 2.1.1-970904
 * @since   1.0.0
 */
class GridView extends \kartik\grid\GridView
{
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
    public $bulkAction = [
        'action'  => '',
        'label'   => '',
        'icon'    => '',
        'class'   => '',
        'message' => '',
    ];
    /**
     * @var boolean Defaults to `true`. The entire GridView widget will be parsed via Pjax and auto-rendered
     * inside a yii\widgets\Pjax widget container. Individual actions can be disabled in
     *     [[\KHanS\Utils\columns\ActionColumn]]
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
     * @var array|boolean the grid export menu settings. If set to true widget defaults are applied. If set to false
     * --the default-- export menu is not activated. This export menu only prepares the items already displayed on the
     *     page.
     */
    public $export = false;
    /**
     * @var string Arbitrary string to appear in the panel.
     */
    protected $content = '';

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
            "footer"  => "",// always need it for jquery plugin
            'options' => [
                'tabindex' => false // important for Select2 to work properly
            ],
        ]);
        Modal::end();

        $this->pager = Yii::$app->params['pager'];
        if ($this->dataProvider->totalCount <= 25) {
            $this->dataProvider->pagination = ['pageSize' => 25];
        }

        if (empty($this->title)) {
            $this->title = $this->getView()->title;
        }
        if ($this->export !== false) {
            $this->loadExportSegment();
        }

        if ($this->showRefreshButtons === true) {
            $this->showRefreshButtons =
                Html::a('<i class="glyphicon glyphicon-refresh"></i>', Url::current(), [
                    'class' => 'btn btn-default', 'title' => 'بازخوانی داده‌ها با حفظ فیلترها',
                ]) .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to(['']), [
                    'class' => 'btn btn-danger', 'title' => 'بازخوانی صفحه و پاک نمودن فیلترها',
                ]);
        }
        $this->toolbar['content'] = $this->showRefreshButtons . $this->content;
        $this->pjaxSettings['options']['id'] = $this->id;

        $this->panel['heading'] = '<div class="pull-left">' . '<i class="glyphicon glyphicon-list"></i>&nbsp;' . $this->title . '</div>';
        $this->panel['type'] = $this->type;
        $this->panel['before'] = $this->before;
        $this->panel['after'] = $this->after;
        $this->panel['footer'] = $this->footer;

        $this->resizableColumns = false;
        $this->toggleData = false;
        $this->striped = true;
        $this->condensed = true;
        $this->responsive = true;


        if (!empty($this->bulkAction) && is_array($this->bulkAction) && !empty($this->bulkAction['action'])) {
            $this->loadBulkSegment();
        }

        parent::init();
    }

    /**
     * If export component of the grid is active load and place it.
     */
    private function loadExportSegment()
    {
        Icon::map($this->getView(), Icon::FA); //required for font awesome
        if ($this->export === true) {
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
     * If bulk action button is requested, configure it and add it to the panel.
     */
    private function loadBulkSegment()
    {
        if (empty($this->bulkAction['class'])) {
            $this->bulkAction['class'] = 'default';
        }
        if (empty($this->bulkAction['message'])) {
            $this->bulkAction['message'] = 'از انجام این دستور اطمینان دارید؟';
        }

        $this->panel['before'] .= '<div class="pull-left rtl">' .
            '&nbsp;&nbsp;با همه انتخاب شده‌ها&nbsp;&nbsp;<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;' .
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
                ]) .
            '</div>';
    }
}
