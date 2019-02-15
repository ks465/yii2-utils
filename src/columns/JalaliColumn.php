<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 11/11/18
 * Time: 14:14
 */


namespace khans\utils\columns;

use khans\utils\components\Jalali;
use khans\utils\components\StringHelper;

/**
 * Class JalaliColumn holds the desired defaults for Jalali date columns, which include unified format.
 * See [JalaliColumn Guide](guide:columns-jalali-column.md)
 *
 * @package khans\utils\columns
 * @version 0.1.1-971025
 * @since 1.0
 */
class JalaliColumn extends DataColumn
{
    /**
     * @var string default format type see [[Jalali:KHAN_SHORT]] and other constants.
     */
    public $JFormat = Jalali::KHAN_SHORT;

    /**
     * Build and configure the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->width)) {
            $this->width = '100px';
        }
        $this->filterWidgetOptions['htmlOptions']['autocomplete'] = 'off'; //disable browser autocomplete for all filter input elements
        $this->filterType = 'khans\utils\widgets\DatePicker';

        parent::init();
    }

    /**
     * Returns the data cell value.
     *
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int   $index the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     *
     * @return string the data cell value
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);

        if (is_null($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return Jalali::date($this->JFormat, $value);
        }
        if (is_string($value)) {
            $value = preg_match(StringHelper::DATE_STRING, $value, $segments);

            if ($value !== false and $value > 0) {
                return Jalali::date($this->JFormat, Jalali::mktime($segments[1], $segments[2], $segments[3]));
            }
        }

        return $value;
    }
}
