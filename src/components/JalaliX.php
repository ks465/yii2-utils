<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 30/07/18
 * Time: 11:36
 */


namespace KHanS\Utils\components;

use KHanS\Utils\Settings;


/**
 * JalaliX
 * Some additional methods to be added in future
 *
 * @package    pgrad
 * @subpackage Jalali Date
 * @access     protected
 * @author     keyhan sedaghat<keyhansedaghat@netscape.net>
 * @version    0.1.0
 */
class JalaliX extends Jalali
{
    private $timestamp;
    private $thisDate;
    private $woy;
    private $thisWeek;
    private $thisWeekText;
    private $thisWeekEnd;
    private $thisWeekStart;

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getThisDate()
    {
        return $this->thisDate;
    }

    /**
     * @return mixed
     */
    public function getWoy()
    {
        return $this->woy;
    }

    /**
     * @return mixed
     */
    public function getThisWeek()
    {
        return $this->thisWeek;
    }

    /**
     * @return mixed
     */
    public function getThisWeekText()
    {
        return $this->thisWeekText;
    }

    /**
     * @return mixed
     */
    public function getThisWeekStart()
    {
        return $this->thisWeekStart;
    }

    /**
     * @return mixed
     */
    public function getThisWeekEnd()
    {
        return $this->thisWeekEnd;
    }

    /**
     * @inheritdoc
     */
    public function calculatePgradCalendar($timestamp)
    {

        $this->timestamp = $timestamp;
        $this->thisDate = JalaliX::date('Y/m/d/W/w', $this->timestamp);
        list($this->year, $this->month, $this->day, $this->woy, $this->dow) = explode('/', $this->thisDate);

        $startOfMonth = JalaliX::date('W', JalaliX::mktime($this->year, $this->month, 1));

        $this->thisWeek = $this->woy - $startOfMonth + 1;
        $this->thisWeekText = 'هفته ' . Settings::getWeekName($this->thisWeek) . ' ' . Settings::getMonthLongName($this->month);
        $this->thisWeek = 4 * ($this->month - 1) + $this->thisWeek;

        $this->thisWeekStart = JalaliX::date('Y/m/d', JalaliX::mktime($this->year, $this->month, $this->day - $this->dow));
        $this->thisWeekEnd = JalaliX::date('Y/m/d', JalaliX::mktime($this->year, $this->month, $this->day - $this->dow + 4));
    }

    public static function date($format, $timestamp = 0, $decorate = false)
    {
        return parent::date($format, $timestamp, $decorate);
    }
}