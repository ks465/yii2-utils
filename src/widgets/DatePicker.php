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
 * Class DatePicker simplifies date picker widget for forms, by defining preset values for multiple configs.
 * [DatePicker Guide](guide:widgets-date-picker.md) contains all required documents for using this widget.
 *
 * @package KHanS\Utils
 * @version 0.2.1-941201
 * @since   1.0
 */
class DatePicker extends jalaliDatePicker
{
    /**
     * Configure widget
     */
    public function init()
    {
        if (array_key_exists('minViewMode', $this->options) && !empty($this->options['minViewMode'])) {
            if ($this->options['minViewMode'] == 'months') {
                $this->options['format'] = 'yyyy/mm';
            }
            if ($this->options['minViewMode'] == 'years') {
                $this->options['format'] = 'yyyy';
            }
        }
        if (!array_key_exists('format', $this->options) || empty($this->options['format'])) {
            $this->options['format'] = 'yyyy/mm/dd';
        }

        if (!array_key_exists('todayBtn', $this->options) || is_null($this->options['todayBtn'])) {
            $this->options['todayBtn'] = 'linked';
        }

        $this->options['placement'] = 'right';
        $this->options['startView'] = 'decade';
        $this->options['autoclose'] = true;

        $this->htmlOptions['class'] = 'form-control';

        Icon::map($this->getView(), Icon::FA);

        parent::init();
    }
}

