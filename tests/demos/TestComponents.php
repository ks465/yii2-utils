<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:33
 */


namespace KHanS\Utils\tests\demos;


use KHanS\Utils\components\ArrayHelper;
use KHanS\Utils\components\Jalali;
use KHanS\Utils\components\JalaliX;
use KHanS\Utils\components\MathHelper;
use KHanS\Utils\components\SqlFormatter;
use KHanS\Utils\components\StringHelper;
use KHanS\Utils\components\ViewHelper;
use KHanS\Utils\models\KHanModel;
use yii\db\Exception;

class TestComponents extends BaseTester
{
    public function testJalaliInstance()
    {
        try {
            $j = new Jalali();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function testJalaliStatic()
    {
        echo '<pre>';

        $this->writeHeader('Jalali::date(\'Y/m/d H:i:s\')');
        echo Jalali::date('Y/m/d H:i:s') . "\n";

        $this->writeHeader('Jalali::date(\'Y/m/d H:i:s\', time(), flase)');
        echo Jalali::date('Y/m/d H:i:s', time(), false) . "\n";

        $this->writeHeader('Jalali::getYear()');
        echo Jalali::getYear() . "\n";

        $this->writeHeader('Jalali::timestamp()');
        echo Jalali::timestamp() . "\n";

        $this->writeHeader('Jalali::getMinute()');
        echo Jalali::getMinute() . "\n";

        $this->writeHeader('Jalali::getDoW()');
        echo Jalali::getDoW() . "\n";

        echo '</pre>';
    }

    public function testJalaliXInstance()
    {
        try {
            $j = new JalaliX();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function testJalaliXStatic()
    {
        echo '<pre>';

        $this->writeHeader('JalaliX::date(\'Y/m/d H:i:s\')');
        echo JalaliX::date('Y/m/d H:i:s') . "\n";

        $this->writeHeader('JalaliX::date(\'Y/m/d H:i:s\', time())');
        echo JalaliX::date('Y/m/d H:i:s', time()) . "\n";

        $this->writeHeader('JalaliX::getYear()');
        echo JalaliX::getYear() . "\n";

        $this->writeHeader('JalaliX::timestamp()');
        echo JalaliX::timestamp() . "\n";

        $this->writeHeader('JalaliX::getMinute()');
        echo JalaliX::getMinute() . "\n";

        $this->writeHeader('JalaliX::getDoW()');
        echo JalaliX::getDoW() . "\n";

        echo '</pre>';
    }

    public function testMathFloors()
    {
        echo '<pre dir="ltr">' . "\n";

        echo 'MathHelper::floorBy(); Max = 0.75' . "\n";
        for ($i = 0; $i <= 1.2; $i = $i + 0.05) {
            echo number_format($i, 2) . ' @0.2: ' . number_format(MathHelper::floorBy($i, 0.2), 2) . "\t\t";
            echo number_format($i, 2) . ' @0.5: ' . number_format(MathHelper::floorBy($i, null), 2) . "\n";
        }

        echo 'MathHelper::ceilBy($i, 0.2, 0.75)' . "\n";
        for ($i = 0; $i <= 1.2; $i = $i + 0.05) {
            echo number_format($i, 2) . ' @0.2: ' . number_format(MathHelper::ceilBy($i, 0.2), 2) . "\n";
        }

        echo '</pre>' . "\n";
    }

    public function testArrayHelpers()
    {
        $inputArray = [
            [
                'x_active_year'    => '91',
                'grade_value'      => 'ارشد',
                'enter_type_value' => 'قبولی در کنکور',
                'x_gender'         => 'زن',
                'x_students'       => '503',
            ],
            [
                'x_active_year'    => '92',
                'grade_value'      => 'ارشد',
                'enter_type_value' => 'قبولی در کنکور',
                'x_gender'         => 'زن',
                'x_students'       => '552',
            ],
            [
                'x_active_year'    => '93',
                'grade_value'      => 'ارشد',
                'enter_type_value' => 'قبولی در کنکور',
                'x_gender'         => 'زن',
                'x_students'       => '589',
            ],
            [
                'x_active_year'    => '91',
                'grade_value'      => 'ارشد',
                'enter_type_value' => 'دوره‌های بین‌الملل',
                'x_gender'         => 'مرد',
                'x_students'       => '201',
            ],
            [
                'x_active_year'    => '92',
                'grade_value'      => 'ارشد',
                'enter_type_value' => 'دوره‌های بین‌الملل',
                'x_gender'         => 'مرد',
                'x_students'       => '200',
            ],
            [
                'x_active_year'    => '95',
                'grade_value'      => 'دکترا',
                'enter_type_value' => 'دوره‌های خودگردان',
                'x_gender'         => 'مرد',
                'x_students'       => '54',
            ],
            [
                'x_active_year'    => '96',
                'grade_value'      => 'دکترا',
                'enter_type_value' => 'دوره‌های خودگردان',
                'x_gender'         => 'مرد',
                'x_students'       => '44',
            ],
        ];

        echo '<pre dir="ltr">';

        $this->writeHeader('ArrayHelper::pivot($inputArray, \'x_active_year\', [\'grade_value\',\'x_gender\'], \'x_students\')');
        var_export(ArrayHelper::pivot($inputArray, 'x_active_year', ['grade_value', 'x_gender'], 'x_students'));

        $this->writeHeader('ArrayHelper::pivot($inputArray, [\'enter_type_value\',\'x_gender\'], \'grade_value\', function ($dataArray){
                 return $dataArray[\'x_active_year\'] . \'/\' . $dataArray[\'x_students\'];
             })');
        var_export(ArrayHelper::pivot($inputArray, [
            'enter_type_value', 'x_gender',
        ], 'grade_value', function($dataArray) {
            return $dataArray['x_active_year'] . '/' . $dataArray['x_students'];
        }));

        $this->writeHeader('ViewHelper::groupBy($inputArray, [\'grade_value\',\'x_gender\'], \'x_students\')');
        var_export(ArrayHelper::groupBy($inputArray, ['grade_value', 'x_gender'], 'x_students'));

        $this->writeHeader('ArrayHelper::groupBy($inputArray, \'grade_value\', function ($dataArray){
                 return $dataArray[\'x_active_year\'] / $dataArray[\'x_students\'];
             })');
        var_export(ArrayHelper::groupBy($inputArray, 'grade_value', function($dataArray) {
            return $dataArray['x_active_year'] / $dataArray['x_students'];
        }));

        echo '</pre>';
    }

    public function testSqlFormatter()
    {
        $sql = 'select * from table where i = 1 group by x having z > 1 order by alpha';
        $this->writeHeader($sql);

        $this->writeHeader('SqlFormatter::format($sql);');
        echo SqlFormatter::format($sql);

        $this->writeHeader('SqlFormatter::format($sql, false);');
        echo SqlFormatter::format($sql, false);


        $sql = KHanModel::find()
            ->andWhere(['i' => 1])
            ->groupBy(['x'])
            ->having(['>', 'z', 1])
            ->orderBy(['alpha' => SORT_ASC])
            ->createCommand()->rawSql;
        $this->writeHeader($sql);

        $this->writeHeader('SqlFormatter::format($sql);');
        echo SqlFormatter::format($sql);

        $this->writeHeader('SqlFormatter::format($sql, false);');
        echo SqlFormatter::format($sql, false);
    }

    public function testCorrectYaKa()
    {
        echo '<pre style="font-family: Helvetica,serif !important;">';

        $test = 'ی ي ک ك 1.2 ۱٫۲';
        $this->writeHeader($test);

        $this->writeHeader('StringHelper::correctYaKa($test);');
        echo StringHelper::correctYaKa($test);

        $this->writeHeader('StringHelper::correctYaKa($test, true);');
        echo StringHelper::correctYaKa($test, true);
        echo '</pre>';
    }

    public function testTrimAll()
    {
        $inputArray = [
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

        echo '<pre dir="ltr">';
        $this->writeHeader('StringHelper::trimAll($inputArray);');
        var_export(StringHelper::trimAll($inputArray));
        echo '</pre>';
    }

    public function testConvertDigits()
    {
        echo '<pre style="font-family: Helvetica,serif">';
        $test = '1.2 ۱٫۲';
        $this->writeHeader($test);
        $this->writeHeader('StringHelper::convertDigits($test);');
        echo StringHelper::convertDigits($test);

        $this->writeHeader('StringHelper::convertDigits($test, true);');
        echo StringHelper::convertDigits($test, true);
        echo '</pre>';
    }

    public function testPadding()
    {
        $text1 = 'راه انداز';
        $text2 = 'راه‌انداز';
        echo '<pre>';

        $length = 12;
        $this->writeHeader('$length = 12;');
        $this->writeHeader('str_pad($text1, $length, \'-\',STR_PAD_LEFT);');
        echo str_pad($text1, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('StringHelper::mb_str_pad($text1, $length, \'-\',STR_PAD_LEFT);');
        echo StringHelper::mb_str_pad($text1, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('str_pad($text2, $length, \'-\',STR_PAD_LEFT);');
        echo str_pad($text2, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('StringHelper::mb_str_pad($text2, $length, \'-\',STR_PAD_LEFT);');
        echo StringHelper::mb_str_pad($text2, $length, '-', STR_PAD_LEFT);

        $length = 20;
        $this->writeHeader('$length = 20;');
        $this->writeHeader('str_pad($text1, $length, \'-\',STR_PAD_LEFT);');
        echo str_pad($text1, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('StringHelper::mb_str_pad($text1, $length, \'-\',STR_PAD_LEFT);');
        echo StringHelper::mb_str_pad($text1, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('str_pad($text2, $length, \'-\',STR_PAD_LEFT);');
        echo str_pad($text2, $length, '-', STR_PAD_LEFT);
        $this->writeHeader('StringHelper::mb_str_pad($text2, $length, \'-\',STR_PAD_LEFT);');
        echo StringHelper::mb_str_pad($text2, $length, '-', STR_PAD_LEFT);

        echo '</pre>';
    }

    public function testMobiles()
    {
        $this->writeHeader('ViewHelper::formatPhone(2112345678);');
        echo ViewHelper::formatPhone(2112345678);
        $this->writeHeader('ViewHelper::formatPhone(9001234567);');
        echo ViewHelper::formatPhone(9001234567);
        $this->writeHeader('ViewHelper::formatPhone(1231234567);');
        echo ViewHelper::formatPhone(1231234567);
    }

    public function testNIDs()
    {
        $this->writeHeader('ViewHelper::formatNID(12345678);');
        echo ViewHelper::formatNID(12345678);
        $this->writeHeader('ViewHelper::formatNID(123456789);');
        echo ViewHelper::formatNID(123456789);
        $this->writeHeader('ViewHelper::formatNID(1234567890);');
        echo ViewHelper::formatNID(1234567890);
    }
}