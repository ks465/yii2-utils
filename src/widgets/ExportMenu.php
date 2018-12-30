<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 1/3/17
 * Time: 5:41 PM
 */


namespace khans\utils\widgets;

use kartik\icons\Icon;
use khans\utils\components\Jalali;

/**
 * Class ExportMenu offers unified and simplified export menu widget.
 * This can be used every where in the page or could be passed to [[export]] property of [[GridView]]
 *
 * @package common\widgets
 * @version 1.2.0-971009
 * @since 1.0.0
 */
class ExportMenu extends \kartik\export\ExportMenu
{
    const EXPORT_REQUEST = 'khan_request_export';

    /**
     * Define preset values for the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->filename)) {
            $this->filename = str_replace(' ', '_', $this->getView()->title) .
                Jalali::date(Jalali::KHAN_FILENAME, time(), false);
        }

        if (empty($this->exportRequestParam)) {
            $this->exportRequestParam = self::EXPORT_REQUEST;
        }

//        $this->target = self::TARGET_POPUP;
        $this->clearBuffers = true;
        $this->initProvider = true;
        $this->fontAwesome = true;
        $this->template = "{menu}\n{columns}";

        if (empty($this->exportConfig)) {
            $this->exportConfig = [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
            ];
        }

        $this->messages = [
            'allowPopups'      => 'بسته به داده‌ها و صفحه انتخاب شده، شاید این کار زمان نیاز داشته باشد.',
            'confirmDownload'  => 'تهیه فایل درخواستی آغاز شود؟',
            'downloadProgress' => 'در حال ساخت فایل',
            'downloadComplete' => 'فایل آماده دریافت است.',

        ];
        $this->docProperties['title'] = 'مرکز آمار و داده‌پردازی';
        $this->docProperties['subject'] = 'کیهان صداقت' . ' ' . 'keyhansedaghat@netscape.net';
        $this->docProperties['keywords'] = 'AUT, KHanS';
        $this->docProperties['company'] = 'KHanS.org';

        $this->columnSelectorOptions['class'] = 'btn-info';
        $this->dropdownOptions['class'] = 'btn-info';
        $this->dropdownOptions['menuOptions'] = ['class' => 'dropdown-menu-right', 'style' => 'z-index: 123456;'];
        $this->columnSelectorMenuOptions = ['class' => 'dropdown-menu-right', 'style' => 'z-index: 123456;'];

        Icon::map($this->getView(), Icon::FA); //required

        parent::init();

        $this->setNoExporters();
    }

    /**
     * Filter unnecessary columns --like ActionColumns.
     */
    private function setNoExporters()
    {
        foreach ($this->columns as $id => $column) {
            if (is_a($column, '\yii\grid\ActionColumn')) {
                $this->noExportColumns[] = $id;
            } elseif (is_a($column, '\khans\utils\widgets\columns\ActionColumn')) {
                $this->noExportColumns[] = $id;
            } elseif (in_array($column->attribute,
                [
                    'updated_at',
                    'created_at',
                    'updated_by',
                    'created_by',
                    'auth_key',
                    'password_hash',
                    'password_reset_token',
                ]
            )) {
                $this->noExportColumns[] = $id;
            }
        }
    }
}
