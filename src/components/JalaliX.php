<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 30/07/18
 * Time: 11:36
 */


namespace KHanS\Utils\components;

use Exception;


/**
 * JalaliX
 * Some additional capability added to [[Jalali]] Class.
 *
 * These capabilities require an instance of class to be present. So the JalaliX class is designed to be instantiated.
 * The two key methods of parent class, [[Jalali::date]] and [[Jalali::mktime]] are disabled. Instead the constructor
 * allows to create objects.
 *
 * @package    pgrad
 * @subpackage Jalali Date
 * @access     protected
 * @author     keyhan sedaghat<keyhansedaghat@netscape.net>
 * @version    0.1.0-970816
 * @since      1.0
 */
class JalaliX extends Jalali
{
    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var int
     */
    private $year;
    /**
     * @var int
     */
    private $month;
    /**
     * @var int
     */
    private $day;
    /**
     * @var int
     */
    private $woy;
    /**
     * @var int 1-based week number in the month
     */
    private $thisWeek;
    /**
     * @var int date of the ending day of the week
     */
    private $weekEnd;
    /**
     * @var int date of the starting day of the week
     */
    private $weekStart;
    /**
     * @var int week number of the first day of the current month
     */
    private $startWeekOfMonth;
    /**
     * @var int week number of the last day of the current month
     */
    private $endWeekOfMonth;

    /** @noinspection PhpMissingParentConstructorInspection */

    /**
     * JalaliX constructor.
     *
     * @param int    $year
     * @param int    $month
     * @param    int $day
     * @param int    $hour
     * @param int    $minute
     * @param int    $second
     */
    public function __construct($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        if (func_num_args() == 1) {
            $this->timestamp = $year;
        } else {
            if (func_num_args() >= 3) {
                $this->timestamp = parent::mktime($year, $month, $day, $hour, $minute, $second);
            } else {
                $this->timestamp = time();
            }
        }

        parent::_date($this->timestamp);
        $this->year = static::getYear();
        $this->month = static::getMonth();
        $this->day = static::getDay();
        $this->woy = static::weekOfYear();

        $this->calculateCalendar();
    }

    /**
     * Calculate more variables in a calendar
     */
    private function calculateCalendar()
    {
        $startOfMonth = parent::mktime($this->year, $this->month, 1);
        $endOfMonth = parent::mktime($this->year, $this->month + 1, 1) - 1;

        $this->startWeekOfMonth = parent::date('W', $startOfMonth);
        $this->endWeekOfMonth = parent::date('W', $endOfMonth);

        $this->thisWeek = (int)($this->woy - $this->startWeekOfMonth + 1);

        $this->weekStart = parent::date('Y/m/d', parent::mktime($this->year, $this->month, $this->day - $this->dayOfWeek() + 1));
        $this->weekEnd = parent::date('Y/m/d', parent::mktime($this->year, $this->month, $this->day - $this->dayOfWeek() + 3));
    }

    /**
     * This class is not designed to have static constructors. Use [[Jalali::date]] instead.
     *
     * @param string $format
     * @param int    $timestamp
     * @param bool   $decorate
     *
     * @return mixed|void
     * @throws Exception
     */
    public static function date($format, $timestamp = 0, $decorate = false)
    {
        throw new Exception('Class ' . get_called_class() . ' should not be called statically. use parent class Jalali.');
    }

    /**
     * This class is not designed to have static constructors. Use [[Jalali::mktime]] instead.
     *
     * @param mixed $year
     * @param mixed $month
     * @param mixed $day
     * @param int   $hour
     * @param int   $minute
     * @param int   $second
     *
     * @return int|void
     * @throws Exception
     */
    public static function mktime($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        throw new Exception('Class ' . get_called_class() . ' should not be called statically. use parent class Jalali.');
    }

    /**
     * Return 1-based number of week in the current month
     *
     * @return int
     */
    public function getWoM()
    {
        return $this->thisWeek;
    }

    /**
     * Return a simple string as `هفته سوم شهریور`
     *
     * @return string
     */
    public function getWoMString()
    {
        return 'هفته ' . $this->getWeekName($this->thisWeek) . ' ' . $this->monthName($this->month);
    }

    /**
     * Return starting day of the current week in YYYY/MM/DD format.
     *
     * @return string
     */
    public function getWeekStart()
    {
        return $this->weekStart;
    }

    /**
     * Return ending day of the current week in YYYY/MM/DD format.
     *
     * @return string
     */
    public function getWeekEnd()
    {
        return $this->weekEnd;
    }

    /**
     * Return starting week number of the current month
     *
     * @return int
     */
    public function getStartWeekOfMonth()
    {
        return $this->startWeekOfMonth;
    }

    /**
     * Return ending week number of the current month
     *
     * @return int
     */
    public function getEndWeekOfMonth()
    {
        return $this->endWeekOfMonth;
    }

    /**
     * Checks the specified year for a leap year.
     *
     * The return value is the number of the leap year(1 - 31) in one cycle
     * for leap years and false for normal years.
     *
     * @return bool|int
     */
    public function getIsLeap()
    {
        return parent::isLeap($this->year);
    }
}