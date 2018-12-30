<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/09/18
 * Time: 21:44
 */


namespace khans\utils\tests\demos;

use khans\utils\components\BlackHtmlVarDumpTheme;
use khans\utils\components\BlueHtmlVarDumpTheme;
use khans\utils\components\CliVarDumpTheme;
use khans\utils\components\FileVarDumpTheme;
use khans\utils\components\GreenHtmlVarDumpTheme;
use khans\utils\components\RedHtmlVarDumpTheme;
use khans\utils\components\VarDump;


/**
 * Class TestDebug load demo files for the decorated VarDump of the yii2-utils package
 *
 * @package khans\utils\tests
 * @version 0.1.0-970915
 * @since   1.0
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
            'Remember: You need to add <code>require_once \Yii::getAlias(\'@khan/src/components/VarDump.php\');</code> in your config scripts.' .
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
//        \khans\utils\Debug::vdd($this->test);
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

    public function testThemes()
    {
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
