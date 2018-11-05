<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 2/20/16
 * Time: 4:40 PM
 */


namespace KHanS\Utils\widgets;


use faravaghi\jalaliDatePicker\jalaliDatePicker;
use kartik\icons\Icon;

/**
 * Class DatePicker simplifies date picker widget for forms
 *
 * @inheritdoc
 * @package common\widgets
 */
class DatePicker extends jalaliDatePicker
{
    public function init()
    {
        $stitch = '/01/01';
        if (array_key_exists('minViewMode', $this->options) && !is_null($this->options['minViewMode'])) {
            if ($this->options['minViewMode'] == 'months') {
                $stitch = '/01';
                $this->options['format'] = 'yyyy/mm';
            }
        }
        if (!array_key_exists('format', $this->options) || is_null($this->options['format'])) {
            $this->options['format'] = 'yyyy/mm/dd';
        }
        if (!array_key_exists('startDate', $this->options) || is_null($this->options['startDate'])) {
            $year = Jalali::date('Y', time(), false) - 50;
            $this->options['startDate'] = $year . $stitch;
            $this->options['endDate'] = ($year + 55) . $stitch;
        }

        $this->options['placement'] = 'right';
        $this->options['todayBtn'] = 'linked';
        $this->options['startView'] = 'decade';
        $this->options['autoclose'] = true;

        $this->htmlOptions['class'] = 'form-control';

        Icon::map($this->getView(), Icon::FA);

        parent::init();
    }
}

