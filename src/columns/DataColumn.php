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
 * Class DataColumn holds the desired defaults for the GridView columns.
 * See [DataColumn Guide](guide:columns-data-column.md)
 *
 * @package khans\utils\columns
 * @version 0.1.1-980123
 * @since 1.0
 */
class DataColumn extends \kartik\grid\DataColumn
{
    /**
     * Build and configure the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->filterInputOptions['autocomplete'] = 'off'; //disable browser autocomplete for all filter input elements

        if (empty($this->hAlign)) {
            $this->hAlign = GridView::ALIGN_CENTER;
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
        parent::init();
    }

}
