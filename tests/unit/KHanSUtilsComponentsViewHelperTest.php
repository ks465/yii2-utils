<?php


use KHanS\Utils\components\ViewHelper;

class KHanSUtilsComponentsViewHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testImplodeOnSimpleArray()
    {
        $data = ['titleA' => 'valueA1', 'titleB' => 'valueB1',];

        expect('Default delimiter and separator with string instead of array', ViewHelper::implode('A simple string'))
            ->equals("A simple string");

        expect('Default delimiter and separator', ViewHelper::implode($data))
            ->equals("titleA: valueA1\ntitleB: valueB1");
        expect('`@` as delimiter and default separator', ViewHelper::implode($data, '@'))
            ->equals("titleA@valueA1\ntitleB@valueB1");
        expect('`@` as delimiter and and `; ` as separator', ViewHelper::implode($data, '@', '; '))
            ->equals("titleA@valueA1; titleB@valueB1");
    }

    public function testImplodeOnRecursiveArray()
    {
        $data = [
            ['titleA' => 'valueA1', 'titleB' => 'valueB1',],
            ['titleA' => 'valueA2', 'titleB' => 'valueB2',],
            ['titleA' => 'valueA3', 'titleB' => 'valueB3',],
        ];

        expect('Default delimiter and separator with string instead of array', ViewHelper::implode('A simple string'))
            ->equals("A simple string");

        expect('Default delimiter and separator', ViewHelper::implode($data))
            ->equals("0: titleA: valueA1\ntitleB: valueB1\n1: titleA: valueA2\ntitleB: valueB2\n2: titleA: valueA3\ntitleB: valueB3");
    }

    public function testFormatNid()
    {
        expect("Tehran, with 2 leading zeros", ViewHelper::formatNID(12345678))->equals('۰۰۱-۲۳۴۵۶۷-۸');
        expect("Somewhere, with 1 leading zeros", ViewHelper::formatNID(123456789))->equals('۰۱۲-۳۴۵۶۷۸-۹');
        expect("Anywhere, with no leading zeros", ViewHelper::formatNID(1234567890))->equals('۱۲۳-۴۵۶۷۸۹-۰');
    }

    public function testFormatMobile()
    {
        expect("Tehran, with 2 leading zeros", ViewHelper::formatNID(12345678))->equals('۰۰۱-۲۳۴۵۶۷-۸');
        expect("Somewhere, with 1 leading zeros", ViewHelper::formatNID(123456789))->equals('۰۱۲-۳۴۵۶۷۸-۹');
        expect("Anywhere, with no leading zeros", ViewHelper::formatNID(1234567890))->equals('۱۲۳-۴۵۶۷۸۹-۰');
    }
}