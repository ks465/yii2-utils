<?php
use khans\utils\components\FileHelper;


class khansutilscomponentsFileHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string Sample CSV file to read from
     */
    private $inputCSV = __DIR__ . '/../_data/test_attributes.csv';

    /**
     * @var string Sample INI file to read from
     */
    private $inputINI = __DIR__ . '/../_data/tables.ini';

    /**
     * @var string Temporary out put file
     */
    private $outputFile = '/tmp/test-write';

    /**
     *
     * @var array Same data as the sample CSV for assertion
     */
    private $readSimpleData = [
        [1, 'request_a', 'decimal', 'test_entities'],
        [2, 'field_a',   'integer', 'non_existent_1'],
        [3, 'request_b', 'decimal', 'test_entities'],
        [4, 'request_c', 'decimal', 'test_entities'],
        [5, 'campus',    'string',  'non_existent_2']
    ];
    /**
     *
     * @var array Same data as the sample CSV in associative form for assertion
     */
    private $readAssociativeData = [
        ['id' => 1, 'attr_name' => 'request_a', 'attr_type' => 'decimal', 'entity_table' => 'test_entities'],
        ['id' => 2, 'attr_name' => 'field_a', 'attr_type' => 'integer', 'entity_table' => 'non_existent_1'],
        ['id' => 3, 'attr_name' => 'request_b', 'attr_type' => 'decimal', 'entity_table' => 'test_entities'],
        ['id' => 4, 'attr_name' => 'request_c', 'attr_type' => 'decimal', 'entity_table' => 'test_entities'],
        ['id' => 5, 'attr_name' => 'campus', 'attr_type' => 'string', 'entity_table' => 'non_existent_2']
    ];

    /**
     *
     * @var array Sample data for writng CSV files
     */
    private $CSVwriteData = [
        ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
        ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
        ['a' => 'A3', 'b' => 'B3', 'c' => 'C3']
    ];

    protected function _before()
    {
    }

    protected function _after()
    {
        if(file_exists($this->outputFile)){
            unlink($this->outputFile);
        }
    }

    // tests
    public function testLoadCSVSimple()
    {
        $data = FileHelper::loadCSV($this->inputCSV, false);
        expect($data)->equals($this->readSimpleData);

        expect(array_keys(end($data)))->equals(range(0, 3));
    }

    public function testLoadCSVAssociative()
    {
        $data = FileHelper::loadCSV($this->inputCSV, true);
        expect($data)->equals($this->readAssociativeData);

        expect(array_keys(end($data)))->equals(['id', 'attr_name', 'attr_type', 'entity_table']);
    }

    public function testWriteCSVSimple() {
        expect(FileHelper::saveCSV($this->outputFile,$this->CSVwriteData,['a', 'b', 'c']))->equals(3);

        $data = FileHelper::loadCSV($this->outputFile, false);
        expect($data[0])->equals(['A1', 'B1', 'C1']);
    }

    public function testWriteCSVAssociative() {
        expect(FileHelper::saveCSV($this->outputFile,$this->CSVwriteData,['a', 'b', 'c']))->equals(3);

        $data = FileHelper::loadCSV($this->outputFile, true);
        expect($data)->equals($this->CSVwriteData);
    }

    public function testReadIni() {
        $data = FileHelper::loadIni($this->inputINI);

        expect($data['THESIS'])->equals('oci_theses,STUDENTNO,TYPE');
        expect($data['JOINED_TABLES'])->count(10);
    }
}