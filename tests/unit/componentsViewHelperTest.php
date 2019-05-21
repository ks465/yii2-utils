<?php


use khans\utils\components\ViewHelper;

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

    public function testFormatNidRtl()
    {
        expect("Tehran, with 2 leading zeros", ViewHelper::formatNID(12345678, true))->equals('۸-۲۳۴۵۶۷-۰۰۱');
        expect("Somewhere, with 1 leading zeros", ViewHelper::formatNID(123456789, true))->equals('۹-۳۴۵۶۷۸-۰۱۲');
        expect("Anywhere, with no leading zeros", ViewHelper::formatNID(1234567890, true))->equals('۰-۴۵۶۷۸۹-۱۲۳');
    }

    public function testFormatMobile()
    {
        expect("Tehran local", ViewHelper::formatPhone(2112345678))->equals('۰۲۱-۱۲-۳۴-۵۶-۷۸');
        expect("Mobile Phone", ViewHelper::formatPhone(9001234567))->equals('۰۹۰۰-۱۲۳-۴۵-۶۷');
        expect("Provincial", ViewHelper::formatPhone(1231234567))->equals('۰۱۲۳-۱۲۳-۴۵-۶۷');
        expect("International", ViewHelper::formatPhone(989001234567))->equals('۹۸۹۰۰۱۲۳۴۵۶۷');
        expect("International", ViewHelper::formatPhone(19001234567))->equals('۱۹۰۰-۱۲۳-۴۵-۶۷');
    }

    public function testFormatMobileRtl()
    {
        expect("Tehran local", ViewHelper::formatPhone(2112345678, true))->equals('۷۸-۵۶-۳۴-۱۲-۰۲۱');
        expect("Mobile Phone", ViewHelper::formatPhone(9001234567, true))->equals('۶۷-۴۵-۱۲۳-۰۹۰۰');
        expect("Provincial", ViewHelper::formatPhone(1231234567, true))->equals('۶۷-۴۵-۱۲۳-۰۱۲۳');
        expect("International", ViewHelper::formatPhone(989001234567, true))->equals('۹۸۹۰۰۱۲۳۴۵۶۷');
        expect("International", ViewHelper::formatPhone(19001234567, true))->equals('۶۷-۴۵-۱۲۳-۱۹۰۰');
    }
}
