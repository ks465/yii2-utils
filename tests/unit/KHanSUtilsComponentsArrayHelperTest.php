<?php

use khans\utils\components\ArrayHelper;

class KHanSUtilsComponentsArrayHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $inputArray;

    public function testAffixElementsToSimpleString()
    {
        $array = ['a', 'b', 'c', 'd'];
        expect(ArrayHelper::appendTo($array, '_'))->equals(['a_', 'b_', 'c_', 'd_']);
        expect(ArrayHelper::prependTo($array, '_'))->equals(['_a', '_b', '_c', '_d']);

        $appended = ArrayHelper::appendTo($array, '_');
        expect(ArrayHelper::prependTo($appended, '_'))->equals(['_a_', '_b_', '_c_', '_d_']);
    }

    public function testAffixElementsToSimpleNumbers()
    {
        $array = [1, 2, 3, 4];
        expect(ArrayHelper::appendTo($array, '_'))->equals(['1_', '2_', '3_', '4_']);
        expect(ArrayHelper::prependTo($array, '_'))->equals(['_1', '_2', '_3', '_4']);
    }

    public function testAffixElementsToAssociative()
    {
        $array = ['a' => 'A', 'b' => 'B'];
        expect(ArrayHelper::appendTo($array, '_'))->equals(['a' => 'A_', 'b' => 'B_']);
        expect(ArrayHelper::prependTo($array, '_'))->equals(['a' => '_A', 'b' => '_B']);
    }

    public function testAffixElementsToRecursive()
    {
        $array = ['a' => ['a', 'b', 'c', 'd'], 'b' => [1, 2, 3, 4]];
        expect(ArrayHelper::appendTo($array, '_'))->equals([
            'a' => ['a_', 'b_', 'c_', 'd_'], 'b' => ['1_', '2_', '3_', '4_'],
        ]);
        expect(ArrayHelper::prependTo($array, '_'))->equals([
            'a' => ['_a', '_b', '_c', '_d'], 'b' => ['_1', '_2', '_3', '_4'],
        ]);
    }

    public function testAffixKeysToSimpleString()
    {
        $array = ['a', 'b', 'c', 'd'];
        expect(ArrayHelper::appendToKeys($array, '_'))->equals(['0_' => 'a', '1_' => 'b', '2_' => 'c', '3_' => 'd']);
        expect(ArrayHelper::prependToKeys($array, '_'))->equals(['_0' => 'a', '_1' => 'b', '_2' => 'c', '_3' => 'd']);

        $appended = ArrayHelper::appendToKeys($array, '_');
        expect(ArrayHelper::prependToKeys($appended, '_'))->equals([
            '_0_' => 'a', '_1_' => 'b', '_2_' => 'c', '_3_' => 'd',
        ]);
    }

    public function testAffixKeysToAssociative()
    {
        $array = ['a' => 'A', 'b' => 'B'];
        expect(ArrayHelper::appendToKeys($array, '_'))->equals(['a_' => 'A', 'b_' => 'B']);
        expect(ArrayHelper::prependToKeys($array, '_'))->equals(['_a' => 'A', '_b' => 'B']);
    }

    public function testAffixKeysToRecursive()
    {
        try {
            $array = ['a' => ['a', 'b', 'c', 'd'], 'b' => [1, 2, 3, 4]];
            expect(ArrayHelper::appendToKeys($array, '_'))->equals([
                'a' => ['a_', 'b_', 'c_', 'd_'], 'b' => ['1_', '2_', '3_', '4_'],
            ]);
            expect('Can only flip STRING and INTEGER values!', true)->false();
        } catch (Exception $e) {
        }

        try {
            expect(ArrayHelper::prependToKeys($array, '_'))->equals([
                'a' => ['_a', '_b', '_c', '_d'], 'b' => ['_1', '_2', '_3', '_4'],
            ]);
            expect('Can only flip STRING and INTEGER values!', true)->false();
        } catch (Exception $e) {
        }
    }

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
