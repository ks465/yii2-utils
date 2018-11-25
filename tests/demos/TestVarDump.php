<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/09/18
 * Time: 21:44
 */


namespace KHanS\Utils\tests\demos;

use KHanS\Utils\components\BlackHtmlVarDumpTheme;
use KHanS\Utils\components\CliVarDumpTheme;
use KHanS\Utils\components\FileVarDumpTheme;
use KHanS\Utils\components\GreenHtmlVarDumpTheme;
use KHanS\Utils\components\RedHtmlVarDumpTheme;
use KHanS\Utils\components\BlueHtmlVarDumpTheme;
use KHanS\Utils\components\VarDump;

require_once \Yii::getAlias('@khan/src/components/VarDump.php');

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

    public function zero()
    {
        echo '<p class="alert alert-danger ltr">' .
            'Remember: You need to add <code>require_once \Yii::getAlias(\'@khan/src/components/VarDump.php\');</code> somewhere in your scripts.' .
            '</p>';
    }

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
    public function testThemes(){
        $outputFile = \yii\helpers\Url::to('@app/runtime/vd-output.log');

        $this->writeHeader('$varDump = new VarDump(null, null, null, new CliVarDumpTheme());');
        $varDump = new VarDump(null, null, null, new CliVarDumpTheme());
        echo '<pre class="ltr">';
        $varDump->dump($this->testSample);
        echo '</pre>';

        $this->writeHeader('$varDump = new VarDump(null, null, null, new FileVarDumpTheme(\yii\helpers\Url::to(\'@app/runtime/vd-output.log\')));');
        $varDump = new VarDump(null, null, null, new FileVarDumpTheme($outputFile));
        $varDump->dump($this->testSample);
        $this->writeHeader('Content of the log file:');
        echo '<pre class="ltr">';
        $this->writeHeader(file_get_contents($outputFile));
        echo '</pre>';

        $this->writeHeader('$varDump = new VarDump(null, null, null, new GreenHtmlVarDumpTheme());');
        $varDump = new VarDump(null, null, null, new GreenHtmlVarDumpTheme());
        $varDump->dump($this->testSample);

        $this->writeHeader('$varDump = new VarDump(null, null, null, new BlackHtmlVarDumpTheme());');
        $varDump = new VarDump(null, null, null, new BlackHtmlVarDumpTheme());
        $varDump->dump($this->testSample);

        $this->writeHeader('$varDump = new VarDump(null, null, null, new RedHtmlVarDumpTheme());');
        $varDump = new VarDump(null, null, null, new RedHtmlVarDumpTheme());
        $varDump->dump($this->testSample);

        $this->writeHeader('$varDump = new VarDump(null, null, null, new BlueHtmlVarDumpTheme());');
        $varDump = new VarDump(null, null, null, new BlueHtmlVarDumpTheme());
        $varDump->dump($this->testSample);
    }
}
