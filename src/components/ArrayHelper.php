<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 23/10/18
 * Time: 19:02
 */


namespace KHanS\Utils\components;

/**
 * Class ArrayHelper contains all methods for simplifying work with arrays.
 * For convenience this class extends \yii\helpers\ArrayHelper.
 *
 * @package KHanS\Utils
 * @version 0.2-970803
 * @since   1.0
 */
final class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Aggregating function to sum values
     */
    const FUNC_SUM = 'sum';
    /**
     * Aggregating function to count values
     */
    const FUNC_COUNT = 'count';
    /**
     * Aggregating function to average values
     */
    const FUNC_AVG = 'average';

    /**
     * Convert an array to a pivot one based on at least one column and one row.
     * Note that the closure output of multiple rows are not aggregated.
     *
     * @see    groupBy
     * @since  0.2-970803
     *
     * @param  array          $inputArray  A two-dimensional array containing data
     * @param string|array    $pivotColumn Name(s) of columns in the input array to use as the columns in the output array
     * @param string|array    $pivotRow    Name(s) of columns in the input array to use as the rows in the output array
     * @param string|callable $pivotValue  Name of a numerical column in the input array to sum, or a closure
     *
     * @param string          $aggFunc     Type of aggregation used
     *
     * @return array
     */
    public final static function pivot($inputArray, $pivotColumn, $pivotRow, $pivotValue,
        $aggFunc = ArrayHelper::FUNC_SUM)
    {
        $groups = [];

        foreach ($inputArray as $dataArray) {
            if (is_array($pivotRow)) {
                $rowKey = implode('.', array_intersect_key($dataArray, array_flip($pivotRow)));
            } else {
                $rowKey = $dataArray[$pivotRow];
                $pivotRow = [$pivotRow];
            }

            if (is_array($pivotColumn)) {
                $colKey = implode('.', array_intersect_key($dataArray, array_flip($pivotColumn)));
            } else {
                $colKey = $dataArray[$pivotColumn];
            }

            if (is_numeric($colKey)) {
                $colKey .= '_';
            }

            if (!array_key_exists($rowKey, $groups)) {
                $groups[$rowKey] = [];
            }
            if (!array_key_exists($colKey, $groups[$rowKey])) {
                foreach ($pivotRow as $item) {
                    $groups[$rowKey][$item] = $dataArray[$item];
                }
                $groups[$rowKey][$colKey] = 0;
            }

            if (is_callable($pivotValue)) {
                $groups[$rowKey][$colKey] = call_user_func($pivotValue, $dataArray);
            } else {
                $groups[$rowKey][$colKey] += $dataArray[$pivotValue];
            }
        }

        return $groups;
    }

    /**
     * Convert an array to a pivot one based on at least one row. There is no need to a column attribute.
     * If $pivotValue is a closure, output data would contain a new column named `_data_` containing results of the
     * closure. Note that the closure output of multiple rows are not aggregated.
     *
     * @since  0.2-970803
     *
     * @param  array          $inputArray A two-dimensional array containing data
     * @param string|array    $pivotRow   Name(s) of columns in the input array to use as the rows in the output array
     * @param string|callable $pivotValue Name of a numerical column in the input array to sum, or a closure.
     * @param string          $aggFunc    Type of aggregation used
     *
     * @return array
     */
    public final static function groupBy($inputArray, $pivotRow, $pivotValue, $aggFunc = ArrayHelper::FUNC_SUM)
    {
        $groups = [];

        foreach ($inputArray as $dataArray) {
            if (is_array($pivotRow)) {
                $rowKey = implode('.', array_intersect_key($dataArray, array_flip($pivotRow)));
            } else {
                $rowKey = $dataArray[$pivotRow];
                $pivotRow = [$pivotRow];
            }

            if (is_callable($pivotValue)) {
                $colKey = '_data_';
            } else {
                $colKey = $pivotValue;
            }

            if (!array_key_exists($rowKey, $groups)) {
                $groups[$rowKey] = $dataArray;
                $groups[$rowKey][$colKey] = 0;
            }

            if (is_callable($pivotValue)) {
                $groups[$rowKey][$colKey] = call_user_func($pivotValue, $dataArray);
            } else {
                $groups[$rowKey][$colKey] += $dataArray[$pivotValue];
            }
        }

        return $groups;
    }
}