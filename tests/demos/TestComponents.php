<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:33
 */


namespace khans\utils\tests\demos;


use khans\utils\components\ArrayHelper;
use khans\utils\components\FileHelper;
use khans\utils\components\Jalali;
use khans\utils\components\JalaliX;
use khans\utils\components\MathHelper;
use khans\utils\components\SqlFormatter;
use khans\utils\components\StringHelper;
use khans\utils\components\ViewHelper;
use khans\utils\models\KHanModel;
use yii\db\Exception;

class TestComponents extends BaseTester
{
    protected $skipTests = [
        'testJalaliInstance', 'testJalaliStatic', 'testJalaliXInstance', 'testJalaliXStatic',
        'testMathFloors', 'testArrayHelpers', 'testSqlFormatter', 'testCorrectYaKa', 'testTrimAll',
        'testConvertDigits', 'testPadding', 'testImplode1', 'testImplode2', 'testImplode3', 'testMobiles',
        'testNIDs', 'testLoadCSV', 'testLoadIni', 'testLoadCsvSaveIni',
//        'testNumberToWords1', 'testNumberToWords2', 'testNumberToWords3', 'testNumberToWords4', 'testNumberToWords5',
    ];

    //<editor-fold Desc="Jalali">
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
        echo Jalali::getTimestamp() . "\n";

        $this->writeHeader('Jalali::getMinute()');
        echo Jalali::getMinute() . "\n";

        $this->writeHeader('Jalali::getDoW()');
        echo Jalali::dayOfWeek() . "\n";

        $time = time();
        $this->writeHeader('Jalali::date(\'o\', $time)');
        echo Jalali::date('o', $time) . "\n";

        $this->writeHeader('Jalali::date(\'t\', $time)');
        echo Jalali::date('t', $time) . "\n";

        $this->writeHeader('Jalali::date(\'u\', $time)');
        echo Jalali::date('u', $time) . "\n";

        echo '</pre>';
    }

    public function testJalaliXInstance()
    {
        $j = new JalaliX(1345, 6, 18);

        $this->writeHeader('new JalaliX(1345, 6, 18)');
        var_dump($j);

        $this->writeHeader('$j->getIsLeap();');
        var_dump($j->getIsLeap());
    }

    public function testJalaliXStatic()
    {
        echo '<pre>';

        $this->writeHeader('JalaliX::date(\'Y/m/d H:i:s\')');
        try {
            echo JalaliX::date('Y/m/d H:i:s') . "\n";
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";

        }

        $this->writeHeader('JalaliX::date(\'Y/m/d H:i:s\', time())');
        try {
            echo JalaliX::date('Y/m/d H:i:s', time()) . "\n";
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";

        }

        $this->writeHeader('JalaliX::getYear()');
        echo JalaliX::getYear() . "\n";

        $this->writeHeader('JalaliX::timestamp()');
        echo JalaliX::getTimestamp() . "\n";

        $this->writeHeader('JalaliX::getMinute()');
        echo JalaliX::getMinute() . "\n";

        $this->writeHeader('JalaliX::getDoW()');
        echo JalaliX::dayOfWeek() . "\n";

        echo '</pre>';
    }
    //</editor-fold>

    //<editor-fold Desc="Misc">
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
        $sql = 'SELECT * FROM table WHERE i = 1 GROUP BY x HAVING z > 1 ORDER BY alpha';
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
                'active_year' => '91 ',
                'students'    => ' 503',
            ],
            [
                'active_year' => '  92',
                'students'    => '552  ',
            ],
            [
                'active_year' => ' 93 ',
                'students'    => '  589  ',
            ],
            [
                [
                    'active_year' => '91 ',
                    'students'    => ' 503',
                ],
                [
                    'active_year' => '  92',
                    'students'    => '552  ',
                ],
                [
                    'active_year' => ' 93 ',
                    'students'    => '  589  ',
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

    public function testImplode1()
    {
        $data = ['titleA' => 'valueA3', 'titleB' => 'valueB3',];

        $this->writeHeader('ViewHelper::implode($data);');
        echo(ViewHelper::implode($data));
    }

    public function testImplode2()
    {
        $data = [
            ['titleA' => 'valueA1', 'titleB' => 'valueB1',],
            ['titleA' => 'valueA2', 'titleB' => 'valueB2',],
            ['titleA' => 'valueA3', 'titleB' => 'valueB3',],
        ];

        $this->writeHeader('ViewHelper::implode($data);');
        var_dump(ViewHelper::implode($data));
    }

    public function testImplode3()
    {
        $data = [
            ['titleA' => 'valueA1', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
            ['titleA' => 'valueA2', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
            ['titleA' => 'valueA3', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
        ];

        $this->writeHeader('ViewHelper::implode($data, \'~\', \'+\');');
        var_dump(ViewHelper::implode($data, '~', '+'));
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

    public function testLoadCSV()
    {
        $inputFile = \yii\helpers\Url::to('@khan/tests/demos/input.csv');
        $outputFile = \yii\helpers\Url::to('@app/runtime/output.csv');
        $content = FileHelper::loadCSV($inputFile, true);
        vd('Reading ' . $inputFile, $content);

        $result = FileHelper::saveCSV($outputFile, $content);

        vd('Reading ' . $result . ' rows Written to ' . $outputFile, FileHelper::loadCSV($outputFile, false));
    }

    public function testLoadIni()
    {
        $inputFile = \yii\helpers\Url::to('@khan/tests/demos/input.ini');
        $outputFile = \yii\helpers\Url::to('@app/runtime/output.ini');
        $content = FileHelper::loadIni($inputFile);
        vd('Reading ' . $inputFile, $content);

        $result = FileHelper::saveIni($outputFile, $content);

        vd('Reading ' . $result . ' rows Written to ' . $outputFile, FileHelper::loadIni($outputFile));
    }

    public function testLoadCsvSaveIni()
    {
        $inputFile = \yii\helpers\Url::to('@khan/tests/demos/input.csv');
        $outputFile = \yii\helpers\Url::to('@app/runtime/output.ini');
        $content = FileHelper::loadCSV($inputFile, true);
        vd('Reading ' . $inputFile, $content);

        $result = FileHelper::saveIni($outputFile, $content);

        vd('Reading ' . $result . ' rows Written to ' . $outputFile, FileHelper::loadIni($outputFile));
    }
    //</editor-fold>

    //</editor-fold Desc="Number to Word">
    public function testNumberToWords1()
    {
        echo '<pre dir="ltr">' . "\n";
        for ($i = -1000; $i <= 0; $i += 31) {
            echo 'expect("' . number_format($i) . '", MathHelper::numberToWord(' . $i . '))' .
                '->equals("' . MathHelper::numberToWord($i) . '");' . "\n";
        }
        echo '</pre>' . "\n";
    }

    public function testNumberToWords2()
    {
        echo '<pre dir="ltr">' . "\n";
        for ($i = 0; $i <= 1000; $i += 29) {
            echo 'expect("' . number_format($i) . '", MathHelper::numberToWord(' . $i . '))' .
                '->equals("' . MathHelper::numberToWord($i) . '");' . "\n";
        }
        echo '</pre>' . "\n";
    }

    public function testNumberToWords3()
    {
        echo '<pre dir="ltr">' . "\n";
        for ($i = 1; $i < 20; $i++) {
            $j = intval(10 ** $i);
            echo 'expect("' . number_format($j) . '", MathHelper::numberToWord(' . $j . '))' .
                '->equals("' . MathHelper::numberToWord($j) . '");' . "\n";
        }
        echo '</pre>' . "\n";
    }

    public function testNumberToWords4()
    {
        echo '<pre dir="ltr">' . "\n";
        $j = '1';
        for ($i = 1; $i < 20; $i++) {
            $j .= '0';
            echo 'expect("' . $j . '1' . '", MathHelper::numberToWord(' . $j . '1))' .
                '->equals("' . MathHelper::numberToWord($j . '1') . '");' . "\n";
        }
        echo '</pre>' . "\n";
    }

    public function testNumberToWords5()
    {
        echo '<pre dir="ltr">' . "\n";
        $j = '1';
        for ($i = 0; $i < 4; $i += 0.123) {
            echo 'expect("' . $i . '", MathHelper::numberToWord(' . $i . '))' .
                '->equals("' . MathHelper::numberToWord($i) . '");' . "\n";
        }
        echo '</pre>' . "\n";
    }
    //</editor-fold>
}
