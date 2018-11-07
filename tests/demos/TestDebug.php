<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/09/18
 * Time: 21:44
 */


namespace KHanS\Utils\tests\demos;


use KHanS\Utils\components\IronmanHtmlVarDumpTheme;
use KHanS\Utils\Debug;

/**
 * Class TestDebug shows and tests the KHanS\Utils\Debug methods
 *
 * @package KHanS\Utils\tests
 */
class TestDebug extends BaseTester
{
    private $testSample = [
        null,
        true,
        42,
        3.1415,
        "any string",
        'subArray' => [
        ],
    ];

    public function testVD()
    {
        $this->writeHeader('\yii\helpers\VarDumper::dump($this->test);');
        \yii\helpers\VarDumper::dump($this->testSample);
        $this->writeHeader('\KHanS\Utils\Debug::vd($this->test);');
        Debug::vd($this->testSample);

        $this->writeHeader('Use \KHanS\Utils\Debug::vdd($this->test); to stop script afterward');
//        \KHanS\Utils\Debug::vdd($this->test);
    }

    public function testVDC()
    {
        $this->writeHeader('\KHanS\Utils\Debug::vdc($this->test,null, null, null, new \KHanS\Utils\IronmanHtmlVarDumpTheme());');
        Debug::vdc($this->testSample, null, null, null, new IronmanHtmlVarDumpTheme());
        $this->writeHeader('Use \KHanS\Utils\Debug::vdcd($this->test,null, null, null, new \KHanS\Utils\BatmanHtmlVarDumpTheme()); to stop script afterward.');

//        \KHanS\Utils\Debug::vdcd($this->test,null, null, null, new \KHanS\Utils\BatmanHtmlVarDumpTheme());
    }

    public function testSQL()
    {
        $this->writeHeader('\KHanS\Utils\Debug::sql(\'select * from table where id>1 group by data1\');');
        $sql = 'select * from table where id>1 group by data1';
        Debug::sql($sql);
    }

    public function testQuery()
    {
        $this->writeHeader('\KHanS\Utils\Debug::sql(new (\yii\db\Query())->from([\'test\'])->where([1=>2])->groupBy([\'id\', \'time\']));');
        $sql = new \yii\db\Query();
        $sql->from(['test']);
        $sql->where([1 => 2]);
        $sql->groupBy(['id', 'time']);
        Debug::sql($sql);
    }
}