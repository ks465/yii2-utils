<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 16:43
 */


namespace khans\utils\components;

use yii\base\BaseObject;

/**
 * Class ViewHelper contains all the utilities required for simpler and better view of objects in output.
 *
 * @package khans\utils\components
 * @version 0.3.0-971012
 * @since   1.0
 */
class ViewHelper extends BaseObject
{
    /**
     * Implode associative arrays into simple strings or
     *
     * @param array|object $arrayData
     * @param string       $keySeparator use to separate key and value
     * @param string       $itemSeparator use to separate individual items
     *
     * @return string
     */
    public static function implode($arrayData, $keySeparator = ': ', $itemSeparator = "\n"): string
    {
        if (empty($arrayData)) {
            return '';
        }
        if (is_string($arrayData)) {
            return $arrayData;
        }
        $result = '';
        foreach ($arrayData as $key => $value) {
            if (is_array($value)) {
                $value = self::implode($value);
            }
            $result .= trim($key) . $keySeparator . trim($value) . $itemSeparator;
        }

        return trim($result, $itemSeparator);
    }

    /**
     * Format national Iranian ID number to its official form.
     * Use this function with caution. In different environment the output is different, when considering the dash
     * behavior in various context. Specially on copying the result, the change can be dramatic.
     *
     * @param integer $nid numeral presentation of nID
     * @param bool    $rtl in some RTL environments it is required to replace parts to view correctly
     *
     * @return string
     */
    public static function formatNID($nid, $rtl = false): string
    {
        $nid = str_pad($nid, 10, '0', STR_PAD_LEFT);
        if (!preg_match('/^(\d{3})(\d{6})(\d{1})$/', $nid, $matches)) {
            return StringHelper::convertDigits($nid);
        }
        if ($rtl) {
            return StringHelper::convertDigits($matches[3] . '-' . $matches[2] . '-' . $matches[1]);
        }

        return StringHelper::convertDigits($matches[1] . '-' . $matches[2] . '-' . $matches[3]);
    }

    /**
     * Format Iranian phone number to its official form
     * Use this function with caution. In different environment the output is different, when considering the dash
     * behavior in various context. Specially on copying the result, the change can be dramatic.
     *
     * @param integer $phone phone number in a long number format
     * @param bool    $rtl in some RTL environments it is required to replace parts to view correctly
     *
     * @return string
     */
    public static function formatPhone($phone, $rtl = false): string
    {
        $phone = str_pad($phone, 11, '0', STR_PAD_LEFT);

        if ($phone > 2100000000 && $phone < 2200000000) {
            $regex = '/^(\d{3})(\d{2})(\d{2})(\d{2})(\d{2})$/';
        } else {
            $regex = '/^(\d{4})(\d{3})(\d{2})(\d{2})$/';
        }

        if (!preg_match($regex, $phone, $matches)) {
            return StringHelper::convertDigits($phone);
        }
        array_shift($matches);
        if ($rtl) {
            $matches = array_reverse($matches);
        }

        return StringHelper::convertDigits(implode('-', $matches));
    }
}
