<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 21/09/18
 * Time: 10:31
 */


namespace khans\utils\components;


use yii\base\BaseObject;

/**
 * Class MathHelper contains methods to do some mathematical routines easier.
 * For examples please see [Math Helper Guide](guide:components-math-helper.md)
 *
 * @package khans\utils
 * @version 0.1.1-970803
 * @since   1.0
 */
class MathHelper extends BaseObject
{
    /**
     * Default value for stepping functions [[floorBy]] and [[ceilBy]]
     */
    const DEFAULT_STEP = 0.5;

    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step the step to round into
     *
     * @return float
     */
    public static function floorBy($number, $step = null): float
    {
        if (is_null($step)) {
            $step = MathHelper::DEFAULT_STEP;
        }

        return $step * floor($number / $step);
    }

    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step the step to round into
     *
     * @return float
     */
    public static function ceilBy($number, $step = null): float
    {
        if (is_null($step)) {
            $step = MathHelper::DEFAULT_STEP;
        }

        return $step * ceil($number / $step);
    }

    /**
     * Convert a digital number to a word phrase representation of the number.
     * For very big numbers use string to bypass the integer size of the system.
     * Note: Not all big numbers are tested. Use with caution with numbers greater than
     * the system maximum integer number.
     *
     * @param int|string $number
     *
     * @return string
     */
    public static function numberToWord($number): string
    {
        if ($number == 0) {
            return 'صفر';
        }

        $length = MathHelper::ceilBy(strlen($number), 9);
        $string = str_pad($number, $length, '0', STR_PAD_LEFT);

        if ($length > 9) {
            // if number of digits is large recurse the segments
            $text = '';
            $chunks = str_split($string, 9);
            $chunks = array_reverse($chunks);

            foreach ($chunks as $i => $chunk) {
                if ($chunk != 0) {
                    $string = self::numberToWord($chunk) . str_repeat(' میلیارد', $i);
                    if ($string > ' ' and $string != 'صفر') {

                        $text = $string . ($text > ' ' ? ' و ' . $text : '');
                    }
                }
            }

            return trim($text);
        }
        if (strpos($string, '.') !== false) {
            $chunks = explode('.', $string);

            return self::numberToWord($chunks[0]) . ' ممیز ' . self::numberToWord($chunks[1]) .
                ' ' . ArrayHelper::getValue(self::$decimals, strlen($chunks[1]) - 1, '');
        }

        $chunks = str_split($string, 3);
        $chunks = array_reverse($chunks);
        array_walk($chunks, function(&$chunk) { $chunk = MathHelper::doReadNumbers($chunk); });

        $text = '';
        foreach ($chunks as $index => $chunk) {
            if (empty($chunk)) {
                continue;
            }

            $text = $chunk . ' ' . self::$_thousands[$index % 3] . (empty($text) ? '' : ' و ') . $text;
        }

        if ($number < 0) {
            return 'منهای ' . trim($text);
        }

        return trim($text);
    }

    /**
     * @var array prefixes for changing numbers to words
     */
    private static $_thousands = ['', 'هزار', 'میلیون', 'میلیارد',];
    /**
     * @var array text for hundreds place
     */
    private static $position0 = ['', 'یکصد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد',];
    /**
     * @var array text for tens place
     */
    private static $position1 = ['', 'ده', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود',];
    /**
     * @var array text for ones place
     */
    private static $position2 = ['', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه',];
    /**
     * @var array text for numbers eleven through nineteen
     */
    private static $position2_1 = [
        'ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هژده', 'نوزده',
    ];
    /**
     * @var array text for decimal part of numbers
     */
    private static $decimals = ['دهم', 'صدم', 'هزارم', 'ده هزارم', 'صد هزارم', 'میلیونیم',];

    /**
     * Convert a three-digit part of any number into Persian text.
     *
     * @param string $segment A string of three digits containing hundreds, tens, and ones for any number
     *
     * @return string The given number in Persian words
     */
    private static function doReadNumbers(string $segment): string
    {
        $digits = str_split($segment, 1);

        $text = ($digits[0] == 0) ? '' : self::$position0[$digits[0]];

        if ($digits[1] == 1) {
            if (empty($text)) {
                $text = self::$position2_1[$digits[2]];
            } else {
                $text .= ' و ' . self::$position2_1[$digits[2]];
            }

            return trim($text);
        }

        if (empty($text) or $digits[1] == 0) {
            $text .= (($digits[1] == 0) ? '' : self::$position1[$digits[1]]);
        } else {
            $text .= ' و ' . (($digits[1] == 0) ? '' : self::$position1[$digits[1]]);
        }

        if (empty($text) or $digits[2] == 0) {
            $text .= (($digits[2] == 0) ? '' : self::$position2[$digits[2]]);
        } else {
            $text .= ' و ' . (($digits[2] == 0) ? '' : self::$position2[$digits[2]]);
        }

        return trim($text);
    }
}
