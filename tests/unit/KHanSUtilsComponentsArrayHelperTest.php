<?php

use KHanS\Utils\components\ArrayHelper;

class KHanSUtilsComponentsArrayHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $inputArray;

    public function testPivotingWithSingleColumnAndRow()
    {
        expect(ArrayHelper::pivot($this->inputArray, 'active_year', 'gender', 'students'))->equals([
            'Female' => [
                'gender' => 'Female',
                '91_'    => 503,
                '92_'    => 552,
                '93_'    => 44,
            ],
            'Male'   => [
                'gender' => 'Male',
                '91_'    => 255,
                '92_'    => 200,
                '93_'    => 633,
            ],
        ]);
    }

    public function testPivotingWithArrayColumnsAndRows()
    {
        expect(ArrayHelper::pivot($this->inputArray, ['active_year', 'enter_type'], [
            'grade', 'gender',
        ], 'students'))->equals([
            'MSc.Female' => [
                'grade'      => 'MSc',
                'gender'     => 'Female',
                '91.Typical' => 503,
                '92.Typical' => 552,
            ],
            'MSc.Male'   => [
                'grade'      => 'MSc',
                'gender'     => 'Male',
                '91.Pardis'  => 201,
                '92.Pardis'  => 200,
                '93.Typical' => 589,
            ],
            'PhD.Male'   => [
                'grade'     => 'PhD',
                'gender'    => 'Male',
                '91.Pardis' => 54,
                '93.Pardis' => 44,
            ],
            'PhD.Female' => [
                'grade'     => 'PhD',
                'gender'    => 'Female',
                '93.Pardis' => 44,
            ],
        ]);
    }

    // tests

    public function testPivotingWithClosure()
    {
        expect(ArrayHelper::pivot($this->inputArray, [
            'grade', 'gender',
        ], 'active_year', function($dataArray) {
            return $dataArray['active_year'] . '/' . $dataArray['students'];
        }))->equals([
            91 => [
                'active_year' => 91,
                'MSc.Female'  => '91/503',
                'MSc.Male'    => '91/201',
                'PhD.Male'    => '91/54',
            ],
            92 => [
                'active_year' => 92,
                'MSc.Female'  => '92/552',
                'MSc.Male'    => '92/200',
            ],
            93 => [
                'active_year' => 93,
                'MSc.Male'    => '93/589',
                'PhD.Female'  => '93/44',
                'PhD.Male'    => '93/44',
            ],
        ]);
    }

    public function testGroupingWithSingleRow()
    {
        expect(ArrayHelper::groupBy($this->inputArray, [
            'grade', 'gender',
        ], 'students'))->equals([
            'MSc.Female' => [
                'active_year' => 91,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Female',
                'students'    => 1055,
            ],
            'MSc.Male'   => [
                'active_year' => 93,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Male',
                'students'    => 990,
            ],
            'PhD.Male'   => [
                'active_year' => 91,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 98,
            ],
            'PhD.Female' => [
                'active_year' => 93,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Female',
                'students'    => 44,
            ],
        ]);
    }

    public function testGroupingWithClosure()
    {
        expect(ArrayHelper::groupBy($this->inputArray, [
            'grade', 'gender',
        ], function($dataArray) {
            return $dataArray['active_year'] . '/' . $dataArray['students'];
        }))->equals([
            'MSc.Female' => [
                'active_year' => 91,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Female',
                'students'    => 503,
                '_data_'      => '92/552',
            ],
            'MSc.Male'   => [
                'active_year' => 93,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Male',
                'students'    => 589,
                '_data_'      => '92/200',
            ],
            'PhD.Male'   => [
                'active_year' => 91,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 54,
                '_data_'      => '93/44',
            ],
            'PhD.Female' => [
                'active_year' => 93,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Female',
                'students'    => 44,
                '_data_'      => '93/44',
            ],
        ]);
    }

    protected function _before()
    {
        $this->inputArray = [
            [
                'active_year' => 91,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Female',
                'students'    => 503,
            ],
            [
                'active_year' => 92,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Female',
                'students'    => 552,
            ],
            [
                'active_year' => 93,
                'grade'       => 'MSc',
                'enter_type'  => 'Typical',
                'gender'      => 'Male',
                'students'    => 589,
            ],
            [
                'active_year' => 91,
                'grade'       => 'MSc',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 201,
            ],
            [
                'active_year' => 92,
                'grade'       => 'MSc',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 200,
            ],
            [
                'active_year' => 91,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 54,
            ],
            [
                'active_year' => 93,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Female',
                'students'    => 44,
            ],
            [
                'active_year' => 93,
                'grade'       => 'PhD',
                'enter_type'  => 'Pardis',
                'gender'      => 'Male',
                'students'    => 44,
            ],
        ];
    }
}