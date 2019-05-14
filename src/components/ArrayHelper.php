<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 23/10/18
 * Time: 19:02
 */


namespace khans\utils\components;

/**
 * Class ArrayHelper contains all methods for simplifying work with arrays.
 * For convenience this class extends \yii\helpers\ArrayHelper.
 *
 * @package KHanS\Utils
 * @version 0.3.1-971027
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
     * @see    ArrayHelper::groupBy
     * @since  0.2-970803
     *
     * @param  array          $inputArray A two-dimensional array containing data
     * @param string|array    $pivotColumn Name(s) of columns in the input array to use as the columns in the output
     *     array
     * @param string|array    $pivotRow Name(s) of columns in the input array to use as the rows in the output array
     * @param string|callable $pivotValue Name of a numerical column in the input array to sum, or a closure
     *
     * @param string          $aggFunc Type of aggregation used
     *
     * @return array
     */
    public final static function pivot($inputArray, $pivotColumn, $pivotRow, $pivotValue,
        $aggFunc = ArrayHelper::FUNC_SUM)
    {
//todo: use aggFunc and default aggregate funtion
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

            if (is_string($pivotValue)) { //if pivotValue is set to some keyword like 'count' it is treated as callable.
                $groups[$rowKey][$colKey] += $dataArray[$pivotValue];
            } elseif (is_callable($pivotValue)) {
                $groups[$rowKey][$colKey] = call_user_func($pivotValue, $dataArray);
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
     * @param string|array    $pivotRow Name(s) of columns in the input array to use as the rows in the output array
     * @param string|callable $pivotValue Name of a numerical column in the input array to sum, or a closure.
     * @param string          $aggFunc Type of aggregation used
     *
     * @return array
     */
    public final static function groupBy($inputArray, $pivotRow, $pivotValue, $aggFunc = ArrayHelper::FUNC_SUM)
    {
//todo: use aggFunc and default aggregate funtion
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

            if (is_string($pivotValue)) { //if pivotValue is set to some keyword like 'count' it is treated as callable.
                $groups[$rowKey][$colKey] += $dataArray[$pivotValue];
            } elseif (is_callable($pivotValue)) {
                $groups[$rowKey][$colKey] = call_user_func($pivotValue, $dataArray);
            }
        }

        return $groups;
    }

    /**
     * Append the given string to all elements of the specified array
     * Example:
     *
     * ```
     * echo ArrayHelper::appendTo(['a', 'b', 'c', 'd'], '_");
     * // ['a_', 'b_', 'c_', 'd_']
     * echo ArrayHelper::appendTo(['a'=>'A', 'b'=>'B'], '_");
     * // ['a' => 'A_', 'b' => 'B_']
     * echo ArrayHelper::appendTo(['a'=>['a', 'b', 'c', 'd'], 'b'=>[1, 2, 3, 4]], '_");
     * // ['a'=>['a_', 'b_', 'c_', 'd_'], 'b'=>['1_', '2_', '3_', '4_']]
     * ```
     *
     * @param array  $array
     * @param string $string
     *
     * @return array
     */
    public final static function appendTo($array, $string): array
    {
        return array_map(function($item) use ($string) {
            if (is_array($item)) {
                return ArrayHelper::appendTo($item, $string);
            }

            return $item . $string;
        }, $array);
    }

    /**
     * Prepend the given string to all elements of the specified array
     * Example:
     *
     * ```
     * echo ArrayHelper::prependTo(['a', 'b', 'c', 'd'], '_");
     * // ['_a', '_b', '_c', '_d']
     * echo ArrayHelper::prependTo(['a'=>'A', 'b'=>'B'], '_");
     * // ['a' => '_A', 'b' => '_B']
     * echo ArrayHelper::prependTo(['a'=>['a', 'b', 'c', 'd'], 'b'=>[1, 2, 3, 4]], '_");
     * // ['a'=>['_a', '_b', '_c', '_d'], 'b'=>['_1', '_2', '_3', '_4']]
     * ```
     *
     * @param array  $array
     * @param string $string
     *
     * @return array
     */
    public final static function prependTo($array, $string): array
    {
        return array_map(function($item) use ($string) {
            if (is_array($item)) {
                return ArrayHelper::prependTo($item, $string);
            }

            return $string . $item;
        }, $array);
    }

    /**
     * Appends the given string to all keys of the specified array
     * Example:
     *
     * ```
     * echo ArrayHelper::appendToKeys(['a', 'b', 'c', 'd'], '_");
     * // ['0_' => 'a', '1_' => 'b', '2_' => 'c', '3_' => 'd']
     * echo ArrayHelper::appendToKeys(['a'=>'A', 'b'=>'B'], '_");
     * // ['a_' => 'A', 'b_' => 'B']
     * echo ArrayHelper::appendToKeys(['a'=>['a', 'b', 'c', 'd'], 'b'=>[1, 2, 3, 4]], '_");
     * // ['a_'=>['a', 'b', 'c', 'd'], 'b'=>['1', '2', '3', '4']]
     * ```
     *
     * @param array  $array
     * @param string $string
     *
     * @return array
     */
    public final static function appendToKeys($array, $string): array
    {
        return array_flip(ArrayHelper::appendTo(array_flip($array), $string));
    }

    /**
     * Prepend the given string to all keys of the specified array
     * Example:
     *
     * ```
     * echo ArrayHelper::prependToKeys(['a', 'b', 'c', 'd'], '_");
     * // ['_0' => 'a', '_1' => 'b', '_2' => 'c', '_3' => 'd']
     * echo ArrayHelper::prependToKeys(['a'=>'A', 'b'=>'B'], '_");
     * // ['_a' => 'A', '_b' => 'B']
     * echo ArrayHelper::prependToKeys(['a'=>['a', 'b', 'c', 'd'], 'b'=>[1, 2, 3, 4]], '_");
     * // ['a_'=>['a', 'b', 'c', 'd'], 'b'=>['1', '2', '3', '4']]
     * ```
     *
     * @param array  $array
     * @param string $string
     *
     * @return array
     */
    public final static function prependToKeys($array, $string): array
    {
        return array_flip(ArrayHelper::prependTo(array_flip($array), $string));
    }
}
