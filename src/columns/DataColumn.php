<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/11/18
 * Time: 14:14
 */


namespace KHanS\Utils\columns;


use kartik\grid\GridView;

/**
 * Class DataColumn holds the desired defaults for the GridView columns.
 * See [DataColumn Guide](guide:columns-data-column.md)
 *
 * @package KHanS\Utils\columns
 * @version 0.1.0-970820
 * @since 1.0
 */
class DataColumn extends \kartik\grid\DataColumn
{
    /**
     * Build and configure the widget
     */
    public function init()
    {
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