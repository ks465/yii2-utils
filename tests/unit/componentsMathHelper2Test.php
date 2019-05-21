<?php

use khans\utils\components\MathHelper;

class KHanSUtilsComponentsMathHelper2Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testNumberToWord1()
    {
        expect("-1,000", MathHelper::numberToWord(-1000))->equals("منهای یک هزار");
        expect("-969", MathHelper::numberToWord(-969))->equals("منهای نهصد و شصت و نه");
        expect("-938", MathHelper::numberToWord(-938))->equals("منهای نهصد و سی و هشت");
        expect("-907", MathHelper::numberToWord(-907))->equals("منهای نهصد و هفت");
        expect("-876", MathHelper::numberToWord(-876))->equals("منهای هشتصد و هفتاد و شش");
        expect("-845", MathHelper::numberToWord(-845))->equals("منهای هشتصد و چهل و پنج");
        expect("-814", MathHelper::numberToWord(-814))->equals("منهای هشتصد و چهارده");
        expect("-783", MathHelper::numberToWord(-783))->equals("منهای هفتصد و هشتاد و سه");
        expect("-752", MathHelper::numberToWord(-752))->equals("منهای هفتصد و پنجاه و دو");
        expect("-721", MathHelper::numberToWord(-721))->equals("منهای هفتصد و بیست و یک");
        expect("-690", MathHelper::numberToWord(-690))->equals("منهای ششصد و نود");
        expect("-659", MathHelper::numberToWord(-659))->equals("منهای ششصد و پنجاه و نه");
        expect("-628", MathHelper::numberToWord(-628))->equals("منهای ششصد و بیست و هشت");
        expect("-597", MathHelper::numberToWord(-597))->equals("منهای پانصد و نود و هفت");
        expect("-566", MathHelper::numberToWord(-566))->equals("منهای پانصد و شصت و شش");
        expect("-535", MathHelper::numberToWord(-535))->equals("منهای پانصد و سی و پنج");
        expect("-504", MathHelper::numberToWord(-504))->equals("منهای پانصد و چهار");
        expect("-473", MathHelper::numberToWord(-473))->equals("منهای چهارصد و هفتاد و سه");
        expect("-442", MathHelper::numberToWord(-442))->equals("منهای چهارصد و چهل و دو");
        expect("-411", MathHelper::numberToWord(-411))->equals("منهای چهارصد و یازده");
        expect("-380", MathHelper::numberToWord(-380))->equals("منهای سیصد و هشتاد");
        expect("-349", MathHelper::numberToWord(-349))->equals("منهای سیصد و چهل و نه");
        expect("-318", MathHelper::numberToWord(-318))->equals("منهای سیصد و هژده");
        expect("-287", MathHelper::numberToWord(-287))->equals("منهای دویست و هشتاد و هفت");
        expect("-256", MathHelper::numberToWord(-256))->equals("منهای دویست و پنجاه و شش");
        expect("-225", MathHelper::numberToWord(-225))->equals("منهای دویست و بیست و پنج");
        expect("-194", MathHelper::numberToWord(-194))->equals("منهای یکصد و نود و چهار");
        expect("-163", MathHelper::numberToWord(-163))->equals("منهای یکصد و شصت و سه");
        expect("-132", MathHelper::numberToWord(-132))->equals("منهای یکصد و سی و دو");
        expect("-101", MathHelper::numberToWord(-101))->equals("منهای یکصد و یک");
        expect("-70", MathHelper::numberToWord(-70))->equals("منهای هفتاد");
        expect("-39", MathHelper::numberToWord(-39))->equals("منهای سی و نه");
        expect("-8", MathHelper::numberToWord(-8))->equals("منهای هشت");
    }

    public function testNumberToWord2()
    {
        expect("0", MathHelper::numberToWord(0))->equals("صفر");
        expect("29", MathHelper::numberToWord(29))->equals("بیست و نه");
        expect("58", MathHelper::numberToWord(58))->equals("پنجاه و هشت");
        expect("87", MathHelper::numberToWord(87))->equals("هشتاد و هفت");
        expect("116", MathHelper::numberToWord(116))->equals("یکصد و شانزده");
        expect("145", MathHelper::numberToWord(145))->equals("یکصد و چهل و پنج");
        expect("174", MathHelper::numberToWord(174))->equals("یکصد و هفتاد و چهار");
        expect("203", MathHelper::numberToWord(203))->equals("دویست و سه");
        expect("232", MathHelper::numberToWord(232))->equals("دویست و سی و دو");
        expect("261", MathHelper::numberToWord(261))->equals("دویست و شصت و یک");
        expect("290", MathHelper::numberToWord(290))->equals("دویست و نود");
        expect("319", MathHelper::numberToWord(319))->equals("سیصد و نوزده");
        expect("348", MathHelper::numberToWord(348))->equals("سیصد و چهل و هشت");
        expect("377", MathHelper::numberToWord(377))->equals("سیصد و هفتاد و هفت");
        expect("406", MathHelper::numberToWord(406))->equals("چهارصد و شش");
        expect("435", MathHelper::numberToWord(435))->equals("چهارصد و سی و پنج");
        expect("464", MathHelper::numberToWord(464))->equals("چهارصد و شصت و چهار");
        expect("493", MathHelper::numberToWord(493))->equals("چهارصد و نود و سه");
        expect("522", MathHelper::numberToWord(522))->equals("پانصد و بیست و دو");
        expect("551", MathHelper::numberToWord(551))->equals("پانصد و پنجاه و یک");
        expect("580", MathHelper::numberToWord(580))->equals("پانصد و هشتاد");
        expect("609", MathHelper::numberToWord(609))->equals("ششصد و نه");
        expect("638", MathHelper::numberToWord(638))->equals("ششصد و سی و هشت");
        expect("667", MathHelper::numberToWord(667))->equals("ششصد و شصت و هفت");
        expect("696", MathHelper::numberToWord(696))->equals("ششصد و نود و شش");
        expect("725", MathHelper::numberToWord(725))->equals("هفتصد و بیست و پنج");
        expect("754", MathHelper::numberToWord(754))->equals("هفتصد و پنجاه و چهار");
        expect("783", MathHelper::numberToWord(783))->equals("هفتصد و هشتاد و سه");
        expect("812", MathHelper::numberToWord(812))->equals("هشتصد و دوازده");
        expect("841", MathHelper::numberToWord(841))->equals("هشتصد و چهل و یک");
        expect("870", MathHelper::numberToWord(870))->equals("هشتصد و هفتاد");
        expect("899", MathHelper::numberToWord(899))->equals("هشتصد و نود و نه");
        expect("928", MathHelper::numberToWord(928))->equals("نهصد و بیست و هشت");
        expect("957", MathHelper::numberToWord(957))->equals("نهصد و پنجاه و هفت");
        expect("986", MathHelper::numberToWord(986))->equals("نهصد و هشتاد و شش");
    }

    public function testNumberToWord3()
    {
        expect("10", MathHelper::numberToWord(10))->equals("ده");
        expect("100", MathHelper::numberToWord(100))->equals("یکصد");
        expect("1,000", MathHelper::numberToWord(1000))->equals("یک هزار");
        expect("10,000", MathHelper::numberToWord(10000))->equals("ده هزار");
        expect("100,000", MathHelper::numberToWord(100000))->equals("یکصد هزار");
        expect("1,000,000", MathHelper::numberToWord(1000000))->equals("یک میلیون");
        expect("10,000,000", MathHelper::numberToWord(10000000))->equals("ده میلیون");
        expect("100,000,000", MathHelper::numberToWord(100000000))->equals("یکصد میلیون");
        expect("1,000,000,000", MathHelper::numberToWord(1000000000))->equals("یک میلیارد");
        expect("10,000,000,000", MathHelper::numberToWord(10000000000))->equals("ده میلیارد");
        expect("100,000,000,000", MathHelper::numberToWord(100000000000))->equals("یکصد میلیارد");
        expect("1,000,000,000,000", MathHelper::numberToWord(1000000000000))->equals("یک هزار میلیارد");
        expect("10,000,000,000,000", MathHelper::numberToWord(10000000000000))->equals("ده هزار میلیارد");
        expect("100,000,000,000,000", MathHelper::numberToWord(100000000000000))->equals("یکصد هزار میلیارد");
        expect("1,000,000,000,000,000", MathHelper::numberToWord(1000000000000000))->equals("یک میلیون میلیارد");
        expect("10,000,000,000,000,000", MathHelper::numberToWord(10000000000000000))->equals("ده میلیون میلیارد");
        expect("100,000,000,000,000,000", MathHelper::numberToWord(100000000000000000))->equals("یکصد میلیون میلیارد");
        expect("1,000,000,000,000,000,000", MathHelper::numberToWord(1000000000000000000))->equals("یک میلیارد میلیارد");
        expect("10,000,000,000,000,000,000", MathHelper::numberToWord('10000000000000000000'))->equals("ده میلیارد میلیارد");
    }

    public function testNumberToWord4()
    {
        expect("11", MathHelper::numberToWord(11))->equals("یازده");
        expect("101", MathHelper::numberToWord(101))->equals("یکصد و یک");
        expect("1,001", MathHelper::numberToWord(1001))->equals("یک هزار و یک");
        expect("10,001", MathHelper::numberToWord(10001))->equals("ده هزار و یک");
        expect("100,001", MathHelper::numberToWord(100001))->equals("یکصد هزار و یک");
        expect("1,000,001", MathHelper::numberToWord(1000001))->equals("یک میلیون و یک");
        expect("10,000,001", MathHelper::numberToWord(10000001))->equals("ده میلیون و یک");
        expect("100,000,001", MathHelper::numberToWord(100000001))->equals("یکصد میلیون و یک");
        expect("1,000,000,001", MathHelper::numberToWord(1000000001))->equals("یک میلیارد و یک");
        expect("10,000,000,001", MathHelper::numberToWord(10000000001))->equals("ده میلیارد و یک");
        expect("100,000,000,001", MathHelper::numberToWord(100000000001))->equals("یکصد میلیارد و یک");
        expect("1,000,000,000,001", MathHelper::numberToWord(1000000000001))->equals("یک هزار میلیارد و یک");
        expect("10,000,000,000,001", MathHelper::numberToWord(10000000000001))->equals("ده هزار میلیارد و یک");
        expect("100,000,000,000,001", MathHelper::numberToWord(100000000000001))->equals("یکصد هزار میلیارد و یک");
        expect("1,000,000,000,000,001", MathHelper::numberToWord(1000000000000001))->equals("یک میلیون میلیارد و یک");
        expect("10,000,000,000,000,001", MathHelper::numberToWord(10000000000000001))->equals("ده میلیون میلیارد و یک");
        expect("100,000,000,000,000,001", MathHelper::numberToWord(100000000000000001))->equals("یکصد میلیون میلیارد و یک");
        expect("1,000,000,000,000,000,001", MathHelper::numberToWord('1000000000000000001'))->equals("یک میلیارد میلیارد و یک");
    }

    public function testNumberToWord5()
    {
        expect("1,234,567,890,123", MathHelper::numberToWord(1234567890123))
            ->equals('یک هزار و دویست و سی و چهار میلیارد و پانصد و شصت و هفت میلیون و هشتصد و نود هزار و یکصد و بیست و سه');
        expect("234,567,890,123,456,789", MathHelper::numberToWord('234567890123456789'))->equals("دویست و سی و چهار میلیون و پانصد و شصت و هفت هزار و هشتصد و نود میلیارد و یکصد و بیست و سه میلیون و چهارصد و پنجاه و شش هزار و هفتصد و هشتاد و نه");
//        expect("1,234,567,890,123,456,789", MathHelper::numberToWord('1234567890123456789'))->equals("یک میلیارد و دویست و سی و چهار میلیون و پانصد و شصت و هفت هزار و هشتصد و نود میلیارد و یکصد و بیست و سه میلیون و چهارصد و پنجاه و شش هزار و هفتصد و هشتاد و نه");
    }

    public function testDecimals()
    {
        expect("1.2", MathHelper::numberToWord(1.2))->equals("یک ممیز دو دهم");
    }
}
