<?php

use KHanS\Utils\components\StringHelper;

class KHanSUtilsComponentsStringHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $inputArray;
    private $outputArray;

    public function _before()
    {
        $this->inputArray = [
            [
                'x_active_year' => '91 ',
                'x_students'    => ' 503',
            ],
            [
                'x_active_year' => '  92',
                'x_students'    => '552  ',
            ],
            [
                'x_active_year' => ' 93 ',
                'x_students'    => '  589  ',
            ],
            [
                [
                    'x_active_year' => '91 ',
                    'x_students'    => ' 503',
                ],
                [
                    'x_active_year' => '  92',
                    'x_students'    => '552  ',
                ],
                [
                    'x_active_year' => ' 93 ',
                    'x_students'    => '  589  ',
                ],
            ],
        ];
        $this->outputArray = [
            [
                'x_active_year' => '91',
                'x_students'    => '503',
            ],
            [
                'x_active_year' => '92',
                'x_students'    => '552',
            ],
            [
                'x_active_year' => '93',
                'x_students'    => '589',
            ],
            [
                [
                    'x_active_year' => '91',
                    'x_students'    => '503',
                ],
                [
                    'x_active_year' => '92',
                    'x_students'    => '552',
                ],
                [
                    'x_active_year' => '93',
                    'x_students'    => '589',
                ],
            ],
        ];
    }

    // tests
    public function testCorrectYaKaLetters()
    {
        $test = 'ی ي ک ك 1.2 ۱٫۲';
        expect('Test letters only', StringHelper::correctYaKa($test))->equals('ی ی ک ک 1.2 ۱٫۲');
    }

    public function testCorrectYaKaLettersAndFigures()
    {
        $test = 'ی ي ک ك 1.2 ۱٫۲';
        expect('Test letters only', StringHelper::correctYaKa($test, true))->equals('ی ی ک ک 1٫2 ۱٫۲');
    }

    public function testTrimAllString()
    {
        expect('All arrays are trimmed recursively', StringHelper::trimAll('  Test Value   '))->equals('Test Value');
    }

    public function testTrimAllArray()
    {
        expect('All arrays are trimmed recursively', StringHelper::trimAll($this->inputArray[0]))->equals($this->outputArray[0]);
    }

    public function testTrimAllRecursiveArray()
    {
        expect('All arrays are trimmed recursively', StringHelper::trimAll($this->inputArray))->equals($this->outputArray);
    }

    public function testConvertDigitsToPersian()
    {
        $test = '1.2 ۱٫۲';
        expect('All digits are in persian face', StringHelper::convertDigits($test))->equals('۱٫۲ ۱٫۲');
    }

    public function testConvertDigitsFromPersian()
    {
        $test = '1.2 ۱٫۲';
        expect('All digits are in persian face', StringHelper::convertDigits($test, true))->equals('1.2 1.2');
    }

    public function testPaddingLeftOdd()
    {
        $text1 = 'راه انداز';
        $text2 = 'راه‌انداز';
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_LEFT))->equals('---راه انداز');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_LEFT))->equals('----راه‌انداز');
    }

    public function testPaddingRightOdd()
    {
        $text1 = 'راه انداز';
        $text2 = 'راه‌انداز';
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_RIGHT))->equals('راه انداز---');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_RIGHT))->equals('راه‌انداز----');
    }

    public function testPaddingBothOdd()
    {
        $text1 = 'راه انداز';
        $text2 = 'راه‌انداز';
        expect('Multi byte with no zero-space join odd numbers of letters -sided', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_BOTH))->notEquals('--راه انداز-');
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_BOTH))->equals('-راه انداز--');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_BOTH))->equals('--راه‌انداز--');
    }

    public function testPaddingLeftEven()
    {
        $text1 = 'راه اندازی';
        $text2 = 'راه‌اندازی';
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_LEFT))->equals('--راه اندازی');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_LEFT))->equals('---راه‌اندازی');
    }

    public function testPaddingRightEven()
    {
        $text1 = 'راه اندازی';
        $text2 = 'راه‌اندازی';
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_RIGHT))->equals('راه اندازی--');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_RIGHT))->equals('راه‌اندازی---');
    }

    public function testPaddingBothEven()
    {
        $text1 = 'راه اندازی';
        $text2 = 'راه‌اندازی';
        expect('Multi byte with no zero-space join odd numbers of letters', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_BOTH))->equals('-راه اندازی-');
        expect('Multi byte with one zero-space join odd numbers of letters -sided', StringHelper::mb_str_pad($text1, 12, '-', STR_PAD_BOTH))->notEquals('--راه‌اندازی-');
        expect('Multi byte with one zero-space join odd numbers of letters', StringHelper::mb_str_pad($text2, 12, '-', STR_PAD_BOTH))->equals('-راه‌اندازی--');
    }
}