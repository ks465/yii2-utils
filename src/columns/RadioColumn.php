<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/11/18
 * Time: 14:14
 */


namespace khans\utils\columns;

use kartik\grid\GridView;

/**
 * Class RadioColumn holds the desired defaults for the GridView radio columns.
 * See [RadioColumn Guide](guide:columns-radio-column.md)
 *
 * @package khans\utils\columns
 * @version 0.1.0-970904
 * @since 1.0
 */
class RadioColumn extends \kartik\grid\RadioColumn
{

    /**
     * Build and configure the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->name = 'selection';
        $this->hAlign = GridView::ALIGN_CENTER;
        $this->vAlign = GridView::ALIGN_MIDDLE;
        $this->clearOptions['title'] = 'انتخاب را پاک کن';
        $this->clearOptions['class'] = 'kv-align-center kv-align-middle close';
        $this->clearOptions['style'] = 'float: none;';
        parent::init();
    }

}
