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
 * @package khans\utils
 * @version 0.2
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
    public static function implode($arrayData, $keySeparator = ': ', $itemSeparator = "\n")
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
     * Format national Iranian ID number to its official form
     *
     * @param $nid
     *
     * @return string
     */
    public static function formatNID($nid)
    {
        $nid = str_pad($nid, 10, '0', STR_PAD_LEFT);
        if (preg_match('/^(\d{3})(\d{6})(\d{1})$/', $nid, $matches)) {
            return StringHelper::convertDigits($matches[1] . '-' . $matches[2] . '-' . $matches[3]);
        }

        return StringHelper::convertDigits($nid);
    }

    /**
     * Format Iranian phone number to its official form
     *
     * @param integer $phone phone number in a long number format
     *
     * @return string
     */
    public static function formatPhone($phone)
    {
        $phone = str_pad($phone, 11, '0', STR_PAD_LEFT);

        if ($phone > 2100000000 && $phone < 2200000000) {
            $regex = '/^(\d{3})(\d{2})(\d{2})(\d{2})(\d{2})$/';
        } else {
            $regex = '/^(\d{4})(\d{3})(\d{2})(\d{2})$/';
        }

        if (preg_match($regex, $phone, $matches)) {
            array_shift($matches);

            return StringHelper::convertDigits(implode('-', $matches));
        }

        return StringHelper::convertDigits($phone);
    }
}
