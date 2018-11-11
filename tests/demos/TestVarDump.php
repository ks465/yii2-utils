<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/09/18
 * Time: 21:44
 */


namespace KHanS\Utils\tests\demos;


/**
 * Class TestDebug shows and tests the KHanS\Utils\Debug methods
 *
 * @package KHanS\Utils\tests
 */
class TestVarDump extends BaseTester
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

    public function testWho()
    {
        $this->writeHeader('echo who();');
        echo who();
        $this->writeHeader('vd(who());');
        vd(who());
    }

    public function testVD()
    {
        $this->writeHeader('\yii\helpers\VarDumper::dump($this->test);');
        \yii\helpers\VarDumper::dump($this->testSample);
        $this->writeHeader('vd($this->test);');
        vd($this->testSample);

        $this->writeHeader('vdd($this->test); to stop script afterward');
//        \KHanS\Utils\Debug::vdd($this->test);
    }

    public function testSQL()
    {
        $this->writeHeader('explain(\'select * from table where id>1 group by data\');');
        $sql = 'SELECT * FROM table WHERE id>1 GROUP BY data';
        explain($sql);

        $this->writeHeader('xd(\'select * from table where id>1 group by data\'); to stop script afterward');
//        xd($sql);
    }

    public function testQuery()
    {
        $sql = new \yii\db\Query();
        $sql->from(['test']);
        $sql->where([1 => 2]);
        $sql->groupBy(['id', 'time']);

        $this->writeHeader('explain(new (\yii\db\Query())->from([\'test\'])->where([1=>2])->groupBy([\'id\', \'time\']));');
        explain($sql);

        $this->writeHeader('xd(new (\yii\db\Query())->from([\'test\'])->where([1=>2])->groupBy([\'id\', \'time\'])); to stop script afterward');
//        xd($sql);
    }
}