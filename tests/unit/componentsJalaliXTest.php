<?php

use khans\utils\components\JalaliX;

class KHanSUtilsComponentsJalaliXTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var JalaliX
     */
    private $jx;
    /**
     * @var JalaliX
     */
    private $bJX;

    public function testStatics()
    {
        try {
            JalaliX::date('Y');
            expect('Could run static methods!', true)->false();
        } catch (Exception $e) {
        }
        try {
            JalaliX::mktime(1, 2, 3);
            expect('Could run static methods!', true)->false();
        } catch (Exception $e) {
        }
    }

    // tests

    public function testWeekNumberNow()
    {
        expect('getWoM', $this->jx->getWoM())->equals(3);
        expect('getWoMString', $this->jx->getWoMString())->equals('هفته سوم آبان');
    }

    public function testWeekEndingsNow()
    {
        expect('getWeekStart', $this->jx->getWeekStart())->equals('1397/08/12');
        expect('getWeekEnd', $this->jx->getWeekEnd())->equals('1397/08/18');
    }

    public function testMonthEndingsNow()
    {
        expect('getStartWeekOfMonth', $this->jx->getStartWeekOfMonth())->equals(31);
        expect('getEndWeekOfMonth', $this->jx->getEndWeekOfMonth())->equals(35);
    }

    public function testWeekNumberBirth()
    {
        expect('getWoM', $this->bJX->getWoM())->equals(3);
        expect('getWoMString', $this->bJX->getWoMString())->equals('هفته سوم شهریور');
    }

    public function testWeekEndingsBirth()
    {
        expect('getWeekStart', $this->bJX->getWeekStart())->equals('1345/06/13');
        expect('getWeekEnd', $this->bJX->getWeekEnd())->equals('1345/06/19');
    }

    public function testMonthEndingsBirth()
    {
        expect('getStartWeekOfMonth', $this->bJX->getStartWeekOfMonth())->equals(22);
        expect('getEndWeekOfMonth', $this->bJX->getEndWeekOfMonth())->equals(26);
    }

    protected function _before()
    {
        $this->bJX = new JalaliX(1345, 6, 18);
        $this->jx = new JalaliX(1397, 8, 16);
    }
}
