<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 17/4/19
 * Time: 19:55
 */


namespace khans\utils\columns;

/**
 * Class ArithmeticColumn holds the desired defaults for the GridView ArithmeticColumn.
 * See [ArithmeticColumn Guide](guide:columns-arithmetic-column.md)
 * This column only adds support for comparison operators to the [DataColumn]
 * Remember that the search model should change type of data in the `rules()` method
 * to accept string instead of numbers.
 * Also the search model methods for filtering data should be changed into `andFilterCompare`
 * of `orFilterCompare`
 *
 * @package khans\utils\columns
 * @version 0.1.0-980128
 * @since 1.0
 */
class ArithmeticColumn extends DataColumn
{
    /**
     * Build and configure the widget
     */
    public function init()
    {
        $this->filterInputOptions = [
            'class'       => 'form-control ltr',
            'placeHolder' => '<، >، =< و =>',
            'title'       => 'می‌توانید از <، >، =< و => نیز استفاده کنید',
        ];

        if (empty($this->headerOptions)) {
            $this->headerOptions = ['class' => 'kv-align-center kv-align-middle'];
        }
        if (empty($this->contentOptions)) {
            $this->contentOptions = ['class' => 'pars-wrap'];
        }
        parent::init();
    }
}
