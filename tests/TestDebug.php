<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/09/18
 * Time: 21:44
 */


namespace KHanS\Utils\tests;

/**
 * Class TestDebug shows and tests the KHanS\Utils\Debug methods
 *
 * @package KHanS\Utils\tests
 */
class TestDebug
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


    public function runAllTests()
    {
        $this->test['subArray'][] = \Yii::$app->user;
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (in_array($method, ['runAllTests', 'writeHeader'])) {
                continue;
            }
            call_user_func([$this, $method]);
        }
    }

    public function testVD()
    {
        $this->writeHeader('\yii\helpers\VarDumper::dump($this->test);');
        \yii\helpers\VarDumper::dump($this->test);
        $this->writeHeader('\KHanS\Utils\Debug::vd($this->test);');
        \KHanS\Utils\Debug::vd($this->test);

        $this->writeHeader('Use \KHanS\Utils\Debug::vdd($this->test); to stop script afterward');
//        \KHanS\Utils\Debug::vdd($this->test);
    }

    private function writeHeader($header)
    {
        if (php_sapi_name() === 'cli') {
            echo $header . "\n=====\n";
        } else {
            echo '<p dir="ltr">' . $header . '</p>';
        }
    }

    public function testVDC()
    {
        $this->writeHeader('\KHanS\Utils\Debug::vdc($this->test,null, null, null, new \KHanS\Utils\IronmanHtmlVarDumpTheme());');
        \KHanS\Utils\Debug::vdc($this->test, null, null, null, new \KHanS\Utils\IronmanHtmlVarDumpTheme());
        $this->writeHeader('Use \KHanS\Utils\Debug::vdcd($this->test,null, null, null, new \KHanS\Utils\BatmanHtmlVarDumpTheme()); to stop script afterward.');

//        \KHanS\Utils\Debug::vdcd($this->test,null, null, null, new \KHanS\Utils\BatmanHtmlVarDumpTheme());
    }

    public function testSQL()
    {
        $this->writeHeader('\KHanS\Utils\Debug::sql(\'select * from table where id>1 group by data1\');');
        $sql = 'select * from table where id>1 group by data1';
        \KHanS\Utils\Debug::sql($sql);
    }

    public function testQuery()
    {
        $this->writeHeader('\KHanS\Utils\Debug::sql(new (\yii\db\Query())->from([\'test\'])->where([1=>2])->groupBy([\'id\', \'time\']));');
        $sql = new \yii\db\Query();
        $sql->from(['test']);
        $sql->where([1 => 2]);
        $sql->groupBy(['id', 'time']);
        \KHanS\Utils\Debug::sql($sql);
    }
}