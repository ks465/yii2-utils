<?php

use khans\utils\components\Jalali;
use yii\db\Exception;

class KHanSUtilsComponentsJalaliTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $time;

    public function testInstantiating()
    {
        try {
            $j = new Jalali();
            expect('Could instantiate class!', true)->false();
        } catch (Exception $e) {
        }
    }

    // tests

    public function testDate()
    {
        expect('Birthday time', Jalali::date('Y/m/d H:i:s', $this->time))->equals('1345/06/18 10:12:23');
        expect('Birthday time', Jalali::date('Y/m/d H:i:s', -104507257))->equals('1345/06/18 10:12:23');
    }

    public function testMktime()
    {
        expect('Birthday timestamp', Jalali::mktime(1345, 6, 18, 10, 12, 23))->equals(-104507257);
    }

    public function testTimestamp()
    {
        expect('Birthday timestamp', Jalali::getTimestamp())->equals(-104507257);
    }

    public function testGetSecond()
    {
        expect('Birthday second', Jalali::getSecond())->equals(23);
    }

    public function testGetMinute()
    {
        expect('Birthday minute', Jalali::getMinute())->equals(12);
    }

    public function testGetHour()
    {
        expect('Birthday hour', Jalali::getHour())->equals(10);
    }

    public function testGetDay()
    {
        expect('Birthday day', Jalali::getDay())->equals(18);
    }

    public function testGetMonth()
    {
        expect('Birthday month', Jalali::getMonth())->equals(6);
    }

    public function testGetYear()
    {
        expect('Birthday year', Jalali::getYear())->equals(1345);
    }

    public function testGetDow()
    {
        expect('Birthday dow', Jalali::dayOfWeek())->equals(7);
    }

    public function testDaysInMonth()
    {
        $monthDays = [1  => 31, 2 => 31, 3 => 31, 4 => 31, 5 => 31, 6 => 31, 7 => 30, 8 => 30, 9 => 30, 10 => 30,
                      11 => 30, 12 => 29,
        ];
        foreach ($monthDays as $index => $monthDay) {
            $time = Jalali::mktime(1397, $index, 10);
            expect('Days in month', Jalali::date('t', $time))->equals($monthDay);
        }
        $time = Jalali::mktime(1395, 12, 10);
        expect('Days in Esfand leap year', Jalali::date('t', $time))->equals(30);

    }

    public function testOthers()
    {
        //Ensure the Jalali object is set to expected date and time:
        $x = Jalali::date('Y/m/d H:i:s', $this->time);

        expect('Birthday dayOfYear', Jalali::dayOfYear())->equals(173);
        expect('Birthday weekOfYear', Jalali::weekOfYear())->equals(24);
        expect('Birthday getDoW', Jalali::dayOfWeek())->equals(7);

        expect('Birthday isLeap', Jalali::isLeap(1345))->false();
        expect('Latest year isLeap', Jalali::isLeap(1395))->equals(5);

        expect('Short name of month', Jalali::monthShortName(7))->equals('مهر');
        expect('Name of month', Jalali::monthName(7))->equals('مهر');
        expect('Short name of day', Jalali::dayShortName(6))->equals('آ');
        expect('Name of day', Jalali::dayName(6))->equals('آدینه');

        expect('Name of day in month', Jalali::monthDayString(26))->equals('بیست‌و‌ششم');
    }

    public function testOtherDates()
    {
        //Ensure the Jalali object is set to expected date and time:
        $x = Jalali::date('Y/m/d H:i:s', Jalali::mktime(1397, 8, 16, 18, 23, 45));

        expect('Birthday dayOfYear', Jalali::dayOfYear())->equals(232);
        expect('Birthday weekOfYear', Jalali::weekOfYear())->equals(33);
        expect('Birthday getDoW', Jalali::dayOfWeek())->equals(5);

        expect('Birthday isLeap', Jalali::isLeap(1397))->false();
        expect('Latest year isLeap', Jalali::isLeap(1395))->equals(5);

        expect('Short name of month', Jalali::monthShortName(7))->equals('مهر');
        expect('Name of month', Jalali::monthName(7))->equals('مهر');
        expect('Short name of day', Jalali::dayShortName(6))->equals('آ');
        expect('Name of day', Jalali::dayName(6))->equals('آدینه');

        expect('Name of day in month', Jalali::monthDayString(26))->equals('بیست‌و‌ششم');
    }

    public function testConstants()
    {
        expect('Jalali::ATOM', Jalali::date(Jalali::ATOM, $this->time))->equals('1345-06-18\TEH10:12:23+00:00');
        expect('Jalali::COOKIE', Jalali::date(Jalali::COOKIE, $this->time))->equals('آدینه, 18-شهر-1345 10:12:23 TEH');
        expect('Jalali::ISO8601', Jalali::date(Jalali::ISO8601, $this->time))->equals('1345-06-18\TEH10:12:23+0000');
        expect('Jalali::RFC822', Jalali::date(Jalali::RFC822, $this->time))->equals('آ, 18 شهر 45 10:12:23 +0000');
        expect('Jalali::RFC850', Jalali::date(Jalali::RFC850, $this->time))->equals('آدینه, 18-شهر-45 10:12:23 TEH');
        expect('Jalali::RFC1036', Jalali::date(Jalali::RFC1036, $this->time))->equals('آ, 18 شهر 45 10:12:23 +0000');
        expect('Jalali::RFC1123', Jalali::date(Jalali::RFC1123, $this->time))->equals('آ, 18 شهر 1345 10:12:23 +0000');
        expect('Jalali::RFC2822', Jalali::date(Jalali::RFC2822, $this->time))->equals('آ, 18 شهر 1345 10:12:23 +0000');
        expect('Jalali::RFC3339', Jalali::date(Jalali::RFC3339, $this->time))->equals('1345-06-18\TEH10:12:23+00:00');
        expect('Jalali::RFC3339', Jalali::date(Jalali::RFC3339, $this->time))->equals('1345-06-18\TEH10:12:23+00:00');
        expect('Jalali::RSS', Jalali::date(Jalali::RSS, $this->time))->equals('آ, 18 شهر 1345 10:12:23 +0000');
        expect('Jalali::W3C', Jalali::date(Jalali::W3C, $this->time))->equals('1345-06-18\TEH10:12:23+00:00');
    }

    protected function _before()
    {
        $this->time = Jalali::mktime(1345, 6, 18, 10, 12, 23);
    }
}
