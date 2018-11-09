<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 16:34
 */


namespace KHanS\Utils\components;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Class StringHelper contains all the utilities for formatting, correcting and shaping strings for saving or showing.
 *
 * @package KHanS\Utils
 * @version 0.2.0-970817
 * @since   1.0
 */
class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * preg_match pattern to allow only Persian alphabets -- including half-space
     * appropriate for names and excluding digits.
     * Use `mb_ord(string)` to find the unicode value.
     */
    const PERSIAN_NAME = '/^[\x{0600}-\x{06EF}\s\x{200C}ـ_]+$/u';
    /**
     * preg_match pattern to allow Persian alphabets -- including half-space
     * plus digits -- both Persian and Latin -- and period, dash & underline
     */
    const PERSIAN_TITLE = '/^[0-9\x{0600}-\x{06FF}\s\x{200C}\s\p{P}<>]+$/u';

    /**
     * Make sure all of Persian inputs are corrected for the Ya & Ka before application starts processing the input.
     * For this to work you should add the following to the main config:
     * ```
     *   'on beforeRequest' => [
     *      'KHanS\Utils',
     *      'screenInput',
     *    ],
     * ```
     */
    public static function screenInput()
    {
        if (Yii::$app->request->isConsoleRequest) {
            return;
        }
        if (stripos(Yii::$app->request->pathInfo, 'admin') === false) {
            try {
                $out = Yii::$app->request->getBodyParams();
            } catch (InvalidConfigException $e) {
                $out = [];
            }
            foreach ($out as $id => &$data) {
                if ('_guest_CSRF' == $id || '_staff_CSRF' == $id) {
                    continue;
                }
                $data = StringHelper::correctYaKa($data);
            }
            Yii::$app->request->setBodyParams($out);

            $out = Yii::$app->request->getQueryParams();
            foreach ($out as $id => &$data) {
                if (\yii\helpers\StringHelper::endsWith($id, '_CSRF')) {
                    continue;
                }
                $data = StringHelper::correctYaKa($data);
            }
            Yii::$app->request->setQueryParams($out);
        }
    }

    /**
     * Unify bogus characters in strings. Replaces character for some code pages for a more robust search and view.
     *
     * @param array|string $phrase data to be scanned and corrected
     * @param bool         $changeDecimal change decimal point to Persian character
     *
     * @return array|string
     */
    public static function correctYaKa($phrase, $changeDecimal = false)
    {
        if (is_null($phrase)) {
            return null;
        }
        $L = ['ي', 'ك'];
        $F = ['ی', 'ک'];
        if ($changeDecimal) {
            $L[] = '.';
            $F[] = '٫';
        }

        return StringHelper::trimAll(str_replace($L, $F, $phrase));
    }

    /**
     * Trim strings in any data depth but do not change the key of associative arrays.
     *
     * @param string|array $data
     *
     * @return array|string
     */
    public static function trimAll($data)
    {
        if (is_array($data)) {
            array_walk($data, function(&$value) {
                $value = StringHelper::trimAll($value);
            });

            return $data;
        } else {
            return trim($data);
        }
    }

    /**
     * Convert Latin digits to Persian digits or vice versa.
     *
     * @param array|string $phrase data to scan and replace digits
     * @param bool         $reversed direction of conversion
     *
     * @return array|string
     */
    public static function convertDigits($phrase, $reversed = false)
    {
        if (is_null($phrase)) {
            return null;
        }
        $L = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'ي', 'ك'];
        $F = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', 'ی', 'ک'];
        $L[] = '.';
        $F[] = '٫';

        if ($reversed) {
            return StringHelper::trimAll(str_replace($F, $L, $phrase));
        }

        return StringHelper::trimAll(str_replace($L, $F, $phrase));
    }

    /**
     * Rewrite of the PHP::str_pad for Unicode strings considering the multi-byte characters.
     * Besides, it also considers the no-width no-break space in Persian, and adds extra space to compensate the zero
     * width.
     *
     * @param         $input      string The input string.
     * @param         $pad_length integer If the value of pad_length is negative, less than, or equal to the length of
     *                            the input string, no padding takes place.
     * @param string  $pad_str The pad_string may be truncated if the required number of padding characters can't be
     *                            evenly divided by the pad_string's length.
     * @param integer $pad_type Optional argument pad_type can be STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH. If
     *                            pad_type is not specified it is assumed to be STR_PAD_RIGHT.
     * @param null    $encoding
     *
     * @return string Padded string.
     */
    public static function mb_str_pad($input, $pad_length, $pad_str = ' ', $pad_type = STR_PAD_RIGHT, $encoding = null)
    {
        $encoding = ($encoding === null) ? mb_internal_encoding() : $encoding;

        $padBefore = ($pad_type === STR_PAD_BOTH) || ($pad_type === STR_PAD_LEFT);
        $padAfter = ($pad_type === STR_PAD_BOTH) || ($pad_type === STR_PAD_RIGHT);

        $pad_length -= mb_strlen($input, $encoding);

        if (false !== mb_strpos($input, mb_chr(8204))) {
            $pad_length += mb_substr_count($input, mb_chr(8204)); //add extra --required-- space for the half-space in Persian
        }

        $targetLen = ($padBefore && $padAfter) ? ($pad_length / 2) : $pad_length;
        $strToRepeatLen = mb_strlen($pad_str, $encoding);
        $repeatTimes = ceil($targetLen / $strToRepeatLen);
        $repeatedString = str_repeat($pad_str, max(0, $repeatTimes)); // safe if used with valid unicode sequences (any charset)
        $before = $padBefore ? mb_substr($repeatedString, 0, (int)floor($targetLen), $encoding) : '';
        $after = $padAfter ? mb_substr($repeatedString, 0, (int)ceil($targetLen), $encoding) : '';

        return $before . $input . $after;
    }
}