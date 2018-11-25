<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 2/20/16
 * Time: 4:40 PM
 */


namespace KHanS\Utils\widgets;


use faravaghi\jalaliDateRangePicker\jalaliDateRangePicker;
use kartik\icons\Icon;

/**
 * Class DateRangePicker simplifies date range picker widget for forms, by defining preset values for multiple configs.
 * [DateRangePicker Guide](guide:widgets-date-range-picker.md) contains all required documents for using this widget.
 *
 * @package KHanS\Utils
 * @version 0.1.0-980802-dev
 * @since   1.0
 */
class DateRangePicker extends jalaliDateRangePicker
{
    //todo: view has some problems
    //todo: this can not be used as column filter type
    /**
     * Configure widget
     */
    public function init()
    {
        if (array_key_exists('timePicker', $this->options) && $this->options['timePicker'] === true) {
            $this->options['format'] = 'jYYYY/jMM/jDD HH:mm';
            $this->options['timePicker24Hour'] = true;
            $this->options['timePickerIncrement'] = 15;
        }
        if (!array_key_exists('format', $this->options) || empty($this->options['format'])) {
            $this->options['format'] = 'jYYYY/jMM/jDD';
        }
        $this->options['viewformat'] = $this->options['format'];

        $this->options['showDropdowns'] = true;
        $this->options['placement'] = 'right';
        $this->options['opens'] = 'left';

        $this->options['locale'] = [
            'format'           => $this->options['format'],
            'separator'        => ' - ',
            'applyLabel'       => 'انتخاب',
            'cancelLabel'      => 'برگشت',
            'fromLabel'        => 'از',
            'toLabel'          => 'تا',
            'customRangeLabel' => 'Custom',
            'daysOfWeek'       => [
                'یک',
                'دو',
                'سه',
                'چهار',
                'پنج',
                'آدینه',
                'شنبه',
            ],
            'monthNames'       => [
                'فروردین',
                'اردیبهشت',
                'خرداد',
                'تیر',
                'امرداد',
                'شهریور',
                'مهر',
                'آبان',
                'آذر',
                'دی',
                'بهمن',
                'اسفند',
            ],
            'firstDay'         => 6,
        ];

        $this->htmlOptions['class'] = 'form-control';
        $this->htmlOptions['id'] = $this->id;

        Icon::map($this->getView(), Icon::FA);

        parent::init();
    }

}

