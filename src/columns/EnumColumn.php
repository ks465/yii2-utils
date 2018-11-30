<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/11/18
 * Time: 14:14
 */


namespace khans\utils\columns;


use kartik\grid\GridView;
use kartik\select2\Select2;

/**
 * Class EnumColumn holds the desired defaults for the GridView EnumColumn.
 * See [EnumColumn Guide](guide:columns-enum-column.md)
 *
 * @package khans\utils\columns
 * @version 0.1.0-970904
 * @since 1.0
 */
class EnumColumn extends \kartik\grid\EnumColumn
{
    /**
     * Build and configure the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->filterType = GridView::FILTER_SELECT2;
        $this->filterWidgetOptions = [
            'initValueText' => '',
            'hideSearch'    => true,
            'theme'         => Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                'dir'        => 'rtl',
            ],
        ];
        if (empty($this->hAlign)) {
            $this->hAlign = GridView::ALIGN_CENTER;
        }
        if (empty($this->vAlign)) {
            $this->vAlign = GridView::ALIGN_CENTER;
        }
        if (empty($this->headerOptions)) {
            $this->headerOptions = ['class' => 'kv-align-center kv-align-middle'];
        }
        if (empty($this->contentOptions)) {
            $this->contentOptions = ['class' => 'pars-wrap'];
        }
        parent::init();
    }

}
