<?php


namespace khans\utils\components;

use yii\base\BaseObject;
use yii\db\Exception;

/**
 * Class JalaliDate provides an exact scientific approach to creating Persian date
 * with an output interface as similar to php::date() as possible
 *
 * Note 1: [[date]] method changes internals of the Jalali Class. After using [[date]] static method, other static
 * methods of this class will act upon that date/time settings.
 *
 * Note 2: [[mktime]] method does not change internals of Jalali static class. In other words using other static
 * methods of this class after using [[mktime]] method has unpredicted results. If you need a consistent calendar
 * object use [[JalaliX]] instead.
 *
 * Examples:
 *
 * Constructing the class:
 *
 *    Jalali class is not intended to be instantiated. Use JalaliX instead.
 *
 * Calling class methods:
 *
 * ```php
 * 1. $jDate->date( format ) ; //using format syntax same as php::date() syntax generates the string output
 *
 * 2. $jDate->timestamp( ) ; //returns the used(internal) timestamp. php::date() returns equivalent Julian date for
 * this time stamp.
 *
 * Direct call:
 * 1. Jalali::date( format,[time stamp],[decorate] ) ; //using the format outputs the timestamp -- or the current
 * //   stamp if left blank, in the desired shape. Use decorate to show numbers as digits or Persian string numerals.
 * 2. Jalali::timestamp() ; //returns the used(internal) timestamp. php::date() returns equivalent Julian date for
 * this time stamp.
 * ```
 *
 * @see http://www.php.net/manual/en/function.date.php
 *
 * @package    e-vista
 * @subpackage Jalali Date
 * @author     keyhan sedaghat<keyhansedaghat@netscape.net>
 * @copyright  1371-1397(1991-2018)
 * @version    3.2.4-970816
 */
class Jalali extends BaseObject
{
    /* These constants could be used instead of format in [[date]] method. */
    const ATOM = "Y-m-d\TH:i:sP";
    const COOKIE = "l, d-M-Y H:i:s T";
    const ISO8601 = "Y-m-d\TH:i:sO";
    const RFC822 = "D, d M y H:i:s O";
    const RFC850 = "l, d-M-y H:i:s T";
    const RFC1036 = "D, d M y H:i:s O";
    const RFC1123 = "D, d M Y H:i:s O";
    const RFC2822 = "D, d M Y H:i:s O";
    const RFC3339 = "Y-m-d\TH:i:sP";
    const RFC3339_EXTENDED = "Y-m-d\TH:i:s.vP";
    const RSS = "D, d M Y H:i:s O";
    const W3C = "Y-m-d\TH:i:sP";
    const KHAN_SHORT = "Y/m/d H:i:s";
    const KHAN_LONG = "l S F Y، H و i دقیقه";
    const KHAN_FILENAME = "Y_m_d-H_i";
    const KHAN_LOG = "Y_m_d-H_i_s";
    const KHAN_DATE = "Y/m/d";

    /**
     * @var int
     * Timestamp in format of and equivalent to standard unix time.
     * You can access this property through Jalali::timestamp() <strong>after</strong>
     * building the data through Jalali::date()
     */
    private static $timeStamp = 0;
    /**
     * @var array
     * Reference table made by Khayyam for leap years
     */
    private static $Khayyamii = [
        0 => 5, 9, 13, 17, 21, 25, 29, 34, 38, 42, 46, 50, 54, 58, 62, 67, 71, 75, 79, 83, 87, 91, 95, 100, 104, 108,
        112, 116, 120, 124, 0,
    ];

    /**
     * @var double
     * Length of a year
     * Calculated by Khayyam is 365.2422 seconds(approx).
     * But as the years are getting shorter the new value
     *(valid from year 1380/2000) is used instead.
     */
    private static $Khayyam_Year = 365.24218956;
    /**
     * @var double
     * Recent calculations has introduced a correcting factor,
     * which Khayyam could not reach.
     * This is used to better adjust length of each year in seconds.
     */
    private static $Correcting_Khayyam_Year = 0.00000006152;
    /**
     * @var int
     * Count of days at the end of each month
     */
    private static $mountCounter = [0 => 0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336,];
    /**
     * @var int
     * Value of second in output time
     */
    private static $second = 0;
    /**
     * @var int
     * Value of minute in output time
     */
    private static $minute = 0;
    /**
     * @var int
     * Value of hour in output time
     */
    private static $hour = 0;
    /**
     * @var int
     * Value of day in output time
     */
    private static $day = 0;
    /**
     * @var int
     * Value of month in output time
     */
    private static $month = 0;
    /**
     * @var int
     * Value of year in output time
     */
    private static $year = 0;
    /**
     * @var int
     * Number of days from start of the current year
     */
    private static $dayOfYear = 0;
    /**
     * @var string
     * Standard php timeZone identifier('Asia/Tehran')
     */
    private static $timeZone = '';
    /**
     * @var int
     * Day time saving(0|1)
     */
    private static $DTS = 0;
    /**
     * @var int
     * Difference from UTC in hours
     */
    private static $UTCDiff = 0;
    /**
     * @var string
     * Difference from UTC in hours including semicolon
     */
    private static $UTCDiffC = "";
    /**
     * @var int
     * Difference from UTC in seconds
     */
    private static $timezoneOffset = 0;

    /**
     * This class is not designed for instantiating.
     *
     * This method is used to confirm that instantiating Jalali class always fails.
     *
     * @throws Exception Do fail instantiating.
     */
    public function __construct()
    {
        throw new Exception('Class ' . get_called_class() . ' should not be instantiated. Use static methods only.');
    }

    /**
     * Return number of week from beginning of the month in words
     *
     * @param $weekNumber 1-based week number in a month
     *
     * @return string
     */
    public static function getWeekName($weekNumber)
    {
        $weekNames = [
            1 => 'یکم',
            2 => 'دوم',
            3 => 'سوم',
            4 => 'چهارم',
            5 => 'پنجم',
        ];

        $weekNumber = (int)$weekNumber;

        if ($weekNumber > 5 || $weekNumber < 1) {
            return '!' . $weekNumber . '!';
        }

        return $weekNames[$weekNumber];
    }

    /**
     * This is a clone of the internal php function date().
     * See also Constants in Jalali class, which could be used in place of these references.
     *
     * This is the list for reference:
     * <pre>
     * a: Lowercase Ante meridiem and Post meridiem    am or pm
     * A: Uppercase Ante meridiem and Post meridiem    AM or PM
     * d: days from 01 to 31
     * D: days --short-- from ش to آ
     * j: days from 1 to 31
     * l(lowercase 'L'): days from شنبه to آدینه
     * N: number of day in week from 1(شنبه) to 7(آدینه)
     * w: number of day in week
     * S: month days from یکم to سی‌و‌یکم
     * z: day in the year
     * W: week in the year
     * F: Month name from قروردین to اسفند
     * m: Month number from 01 to 12
     * M: month from فرو to اسف
     * n: Month number from 1 to 12
     * Y: full year numeric representation -- 4 digit
     * y: year numeric representation -- 2 digit
     * g: 12-hour format of an hour without leading zeros    1 through 12
     * G: 24-hour format of an hour without leading zeros    0 through 23
     * h: 12-hour format of an hour with leading zeros    01 through 12
     * H: 24-hour format of an hour with leading zeros    00 through 23
     * i: Minutes with leading zeros    00 to 59
     * s: Seconds, with leading zeros    00 through 59
     * T: Timezone abbreviation    Examples: EST, MDT ...
     * U: Seconds since the Unix Epoch(January 1 1970 00:00:00 UTC)    See also time()
     * L: whether it's a leap year
     * I:(capital i) Whether or not the date is in daylight saving time 1 if Daylight Saving Time, 0 otherwise.
     * O: Difference to Greenwich time(UTC) in hours    Example: +0200
     * o: year number
     * P: Difference to Greenwich time(UTC) with colon between hours and minutes(added in PHP 5.1.3)
     * Z: Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of
     * UTC is always positive. -43200 through 50400 c: ISO 8601 date(added in PHP 5)    2004-02-12T15:19:21+00:00 r: »
     * RFC 2822 formatted date    Example: Thu, 21 Dec 2000 16:01:07 +0200 t: number of days in the given month e:
     * Timezone identifier(added in PHP 5.1.0)    Examples: UTC, UTC, Atlantic/Azores u: Microseconds(added in PHP
     * 5.2.2)    Example: 54321 as PHP::date() function it will set to  000000
     *</pre>
     * Following types are not recognized:
     * <pre>
     * B: Swatch Internet time    000 through 999
     * </pre>
     *
     * @param string  $format The format of the outputted date string. See
     *     http://www.php.net/manual/en/function.date.php
     * @param int     $timestamp The unix-type timestamp to be used for output.
     * @param boolean $decorate If true function decorate is used for changing the face of output.
     * If false the normal face of output is returned. For numbers false returns number, true returns string.
     *
     * @return mixed
     */
    public static function date($format, $timestamp = 0, $decorate = false)
    {
        if (is_null($format)) {
            $format = 'Y/m/d';
        }
        if (is_null($timestamp)) {
            return null;
        }

        if (func_num_args() == 1) {
            if (self::getTimestamp() > 0) {
                $timestamp = self::getTimestamp();
            } else {
                $timestamp = time();
            }
        }
        if ($timestamp <= -600000000000) {
            return '';
        }
        self::$timeStamp = $timestamp;
        self::_date(self::$timeStamp);

        if (self::$month == 12) {
            if (self::isLeap(self::$year)) {
                $monthDays = 30;
            } else {
                $monthDays = 29;
            }
        } elseif (self::$month > 6 && self::$month < 12) {
            $monthDays = 30;
        } else {
            $monthDays = 31;
        }

        $format = str_replace("a", (self::$hour <= 12 ? "ق.ظ" : "ب.ظ"), $format);
        $format = str_replace("A", (self::$hour <= 12 ? "ق.ظ" : "ب.ظ"), $format);
        $format = str_replace("d", str_pad(self::$day, 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("D", self::dayShortName(self::_dayOfWeek(self::$year, self::$dayOfYear)), $format);
        $format = str_replace("j", self::$day, $format);
        $format = str_replace("l", self::dayName(self::_dayOfWeek(self::$year, self::$dayOfYear)), $format);
        $format = str_replace("N", self::_dayOfWeek(self::$year, self::$dayOfYear) + 1, $format);
        $format = str_replace("w", self::_dayOfWeek(self::$year, self::$dayOfYear), $format);
        $format = str_replace("S", self::monthDayString(self::$day), $format);
        $format = str_replace("z", self::$dayOfYear, $format);
        $format = str_replace("W", self::weekOfYear(), $format);
        $format = str_replace("F", self::monthName(self::$month), $format);
        $format = str_replace("m", str_pad(self::$month, 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("M", self::monthShortName(self::$month), $format);
        $format = str_replace("n", self::$month, $format);
        $format = str_replace("t", $monthDays, $format);
        $format = str_replace("Y", self::$year, $format);
        $format = str_replace("y", (self::$year % 100), $format);
        $format = str_replace("g", (self::$hour % 12), $format);
        $format = str_replace("G", self::$hour, $format);
        $format = str_replace("h", str_pad((self::$hour % 12), 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("H", str_pad(self::$hour, 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("i", str_pad(self::$minute, 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("s", str_pad(self::$second, 2, '0', STR_PAD_LEFT), $format);
        $format = str_replace("T", "TEH", $format);
        $format = str_replace("U", self::$timeStamp, $format);
        $format = str_replace("u", '000000', $format);
        $format = str_replace("L", self::isLeap(self::$year), $format);
        $format = str_replace("Y", self::$year, $format);
        $format = str_replace("o", self::$year, $format);
        $format = str_replace("I", self::$DTS, $format);
        $format = str_replace("O", self::$UTCDiff, $format);
        $format = str_replace("P", self::$UTCDiffC, $format);
        $format = str_replace("Z", self::$timezoneOffset, $format);
        $format = str_replace("c", self::$year . "-" .
            str_pad(self::$month, 2, '0', STR_PAD_LEFT) . "-" .
            str_pad(self::$day, 2, '0', STR_PAD_LEFT) . "ز" .
            str_pad(self::$hour, 2, '0', STR_PAD_LEFT) . ":" .
            str_pad(self::$minute, 2, '0', STR_PAD_LEFT) . ":" .
            str_pad(self::$second, 2, '0', STR_PAD_LEFT) .
            self::$UTCDiffC, $format);
        $format = str_replace("r", self::dayShortName(self::_dayOfWeek(self::$year, self::$dayOfYear)) . "، " .
            self::$day . " " .
            self::monthShortName(self::$month) . " " .
            self::$year . " " .
            self::$hour . ":" .
            self::$minute . ":" .
            self::$second .
            self::$UTCDiff, $format);
        $format = str_replace("e", self::$timeZone, $format);

        if ($decorate) {
            return self::ParsiNumbers($format);
        } else {
            return $format;
        }
    }

    /**
     * Get current value of the timestamp in Unix timestamp format
     *
     * @return int
     */
    public static function getTimestamp()
    {
        return self::$timeStamp;
    }

    /**
     * Sets the full date data Y;M;D;H;I;S in various class attributes
     *
     * @param int $timeStamp Value of time in Unix timestamp format
     *
     * @return void
     */
    protected static function _date($timeStamp)
    {
        self::$timezoneOffset = date('Z');
        $timeStamp = self::$timezoneOffset + $timeStamp;
        self::$DTS = date('I');
        self::$UTCDiff = date('O');
        self::$UTCDiffC = date('P');

        $Seconds = floor($timeStamp % 60);
        if ($Seconds < 0) {
            $Seconds += 60;
        }
        $Minutes = floor(($timeStamp % 3600) / 60);
        if ($Minutes < 0) {
            $Minutes += 60;
        }
        $Hours = floor(($timeStamp % 86400) / 3600);
        if ($Hours < 0) {
            $Hours += 24;
        }

        //if(self::$DTS == 1) $Hours-- ;

        $Days = floor($timeStamp / 86400);
        $Days += 287;
        $Years = floor(($Days / self::$Khayyam_Year) - ($Days * self::$Correcting_Khayyam_Year));
        $dayOfYear = $Days - round($Years * self::$Khayyam_Year, 0);
        if ($dayOfYear == 0) {
            $dayOfYear = 366;
        }
        $Years += 1348;
        $Months = 0;
        while ($Months < 12 && $dayOfYear > self::$mountCounter[$Months]) {
            $Months++;
        }
        $Days = $dayOfYear - self::$mountCounter[$Months - 1];

        self::$second = $Seconds;
        self::$minute = $Minutes;
        self::$hour = $Hours;
        self::$day = $Days;
        self::$month = $Months;
        self::$year = $Years;
        self::$dayOfYear = $dayOfYear;
    }

    /**
     * Checks the specified year for a leap year.
     *
     * @param int $yearValue Value of a Jalali year.
     *
     * @return integer|boolean
     * The return value is the number of the leap year(1 - 31) in one cycle
     * for leap years and false for normal years.
     */
    public static function isLeap($yearValue)
    {
        $Rasad = Jalali::calcRasad($yearValue);
        $yrNam = $Rasad % 2820;
        $yrNam = $yrNam % 128;
        $leapCount = array_search($yrNam, Jalali::$Khayyamii);

        return $leapCount;
    }

    /**
     * Returns abbreviated --single letter-- names of the weekday.
     *
     * @param int $dayValue 0-based week-day number
     *
     * @return string
     */
    public static function dayShortName($dayValue)
    {
        $weekShort = [0 => 'ش', 'ی', 'د', 'س', 'چ', 'پ', 'آ',];

        $dayValue = (int)$dayValue;

        if ($dayValue > 6 || $dayValue < 0) {
            return '!' . $dayValue . '!';
        }

        return $weekShort[$dayValue];
    }

    /**
     * Returns weekday of the specified day of the year
     *
     * @param int $yearValue Value of a Jalali year.
     * @param int $dayOfYear Day number.
     *
     * @return mixed
     */
    protected static function _dayOfWeek($yearValue, $dayOfYear = 0)
    {
        $Rasad = Jalali::calcRasad($yearValue);

        $count2820 = floor($Rasad / 2820);
        $mod2820 = $Rasad % 2820;
        $count128 = floor($mod2820 / 128);
        $mod128 = $mod2820 % 128;

        $leapCount = 0;
        while (
            $leapCount < count(Jalali::$Khayyamii) &&
            $mod128 > Jalali::$Khayyamii[$leapCount]
        ) {
            $leapCount++;
        }
        $yearStartDay = ($count2820 + 1) * 3 +
            $count128 * 5 +
            $mod128 +
            $leapCount;
        if ($dayOfYear > 0) {
            $dayOfYear--;
        }

        return ($yearStartDay + $dayOfYear) % 7;
    }

    /**
     * Returns names of the weekday in full
     *
     * @param int $dayValue 0-based week-day number
     *
     * @return string
     */
    public static function dayName($dayValue)
    {
        $weekAlpha = [0 => 'شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'آدینه',];

        $dayValue = (int)$dayValue;

        if ($dayValue > 6 || $dayValue < 0) {
            return '!' . $dayValue . '!';
        }

        return $weekAlpha[$dayValue];
    }

    /**
     * Returns long text day of the month
     *
     * @param int $monthDayValue 1-based day number in month
     *
     * @return string
     */
    public static function monthDayString($monthDayValue)
    {
        $monthDays = [
            1 => 'یکم', 'دوم', 'سوم', 'چهارم', 'پنجم', 'ششم', 'هفتم', 'هشتم', 'نهم', 'دهم', 'یازدهم', 'دوازهم',
            'سیزدهم', 'چهاردهم', 'پانزدهم', 'شانزدهم', 'هفدهم', 'هژدهم', 'نوزدهم', 'بیستم', 'بیست‌و‌یکم', 'بیست‌و‌دوم',
            'بیست‌و‌سوم', 'بیست‌و‌چهارم', 'بیست‌و‌پنجم', 'بیست‌و‌ششم', 'بیست‌و‌هفتم', 'بیست‌و‌هشتم', 'بیست‌و‌نهم',
            'سی‌ام', 'سی‌و‌یکم',
        ];
        $monthDayValue = (int)$monthDayValue;
        if ($monthDayValue > 31 || $monthDayValue < 1) {
            return '!' . $monthDayValue . '!';
        }

        return $monthDays[$monthDayValue];
    }

    /**
     * Get value of week number in year
     *
     * @return int
     */
    public static function weekOfYear()
    {
        $x = (7 - self::_dayOfWeek(self::$year, 1)) % 7;
        $z = self::$dayOfYear - $x;

        //echo "Result Two ".$z."<br/>";
        return abs(ceil($z / 7));
    }

    /**
     * Returns names of the month
     *
     * @param int $monthValue 1-based month number in a year
     *
     * @return string
     */
    public static function monthName($monthValue)
    {
        $monthLongName = [
            1 => 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'امرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند',
        ];
        $monthValue = (int)$monthValue;

        if ($monthValue > 12 || $monthValue < 1) {
            return '!' . $monthValue . '!';
        }

        return $monthLongName[$monthValue];
    }

    /**
     * Returns abbreviated --three-letters-- names of the month
     *
     * @param int $monthValue
     *
     * @return string
     */
    public static function monthShortName($monthValue)
    {
        $monthShort = [1 => 'فرو', 'ارد', 'خرد', 'تیر', 'امر', 'شهر', 'مهر', 'آبا', 'آذر', 'دی', 'بهم', 'اسف',];
        $monthValue = (int)$monthValue;

        if ($monthValue > 12 || $monthValue < 1) {
            return '!' . $monthValue . '!';
        }

        return $monthShort[$monthValue];
    }

    /**
     * Converts digits to Persian traditional font face and
     * corrects the no-width space in words.
     * Use the function on the returned value in the source code.
     *
     * @param string $phrase Date/time string with normal digits.
     *
     * @return string Date/time string with Persian numerals.
     */
    private static function ParsiNumbers($phrase)
    {
        $L = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $F = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];

        return str_replace($L, $F, $phrase);
    }

    //<editor-fold desc="Getters">

    /**
     * Calculates the years from reference Rasad year
     *
     * @param int $yearValue
     *
     * @return int
     */
    private static function calcRasad($yearValue)
    {
        $Rasad = $yearValue + 2346;

        return $Rasad;
    }

    /**
     * Creates timestamp depending on the Persian time parameters
     *
     * Note that this method does not change internals of Jalali static class. In other words using other static
     * methods of this class after using mktime method has unpredicted results. If you need a consistent calendar
     * object use [[JalaliX]] instead.
     *
     * @param mixed $year Year number in a Jalali calendar
     * @param mixed $month Month number in a Persian calendar
     * @param mixed $day Day in the month number in a Persian calendar
     * @param mixed $hour Hour in a day time
     * @param mixed $minute Minute in day time
     * @param mixed $second Second in day time
     *
     * @return int
     */
    public static function mktime($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        $timeStamp = $second;
        $timeStamp += $minute * 60;
        $timeStamp += $hour * 60 * 60;

        $dayOfYear = ($day + self::$mountCounter[$month - 1]);
        if ($year < 1300) {
            $year += 1300;
        }
        $year -= 1348;
        $day = $dayOfYear + round((self::$Khayyam_Year * $year), 0);
        $day -= 287;
        $timeStamp += $day * 86400;

        return $timeStamp;
    }

    /**
     * Get second
     *
     * @return int
     */
    public static function getSecond()
    {
        return self::$second;
    }

    /**
     * Get minute
     *
     * @return int
     */
    public static function getMinute()
    {
        return self::$minute;
    }

    /**
     * Get hour
     *
     * @return int
     */
    public static function getHour()
    {
        return self::$hour;
    }

    /**
     * Get day in month value
     *
     * @return int
     */
    public static function getDay()
    {
        return self::$day;
    }

    /**
     * Get month value
     *
     * @return int
     */
    public static function getMonth()
    {
        return self::$month;
    }

    /**
     * Get year value
     *
     * @return int
     */
    public static function getYear()
    {
        return self::$year;
    }

    /**
     * Get number of days from starting of the current week
     *
     * @return int
     */
    public static function dayOfWeek()
    {
        return self::_dayOfWeek(self::$year, self::$dayOfYear) + 1;
    }

    /**
     * Get value of the day in the year
     *
     * @return int
     */
    public static function dayOfYear()
    {
        return self::$dayOfYear;
    }
    //</editor-fold>
}
