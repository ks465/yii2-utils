<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 11:34
 */


namespace KHanS\Utils\tests\demos;


use yii\helpers\FileHelper;

class BaseTester
{
    /**
     * @var array List of tests in each Test* class to skip for debuging purposes.
     */
    protected $skipTests = [];
    /**
     * A helper static method to run all of tests in all of files.
     */
    public static function runAllTests()
    {
        foreach (BaseTester::getAllTests() as $testClass => $allTest) {
            /* @var $tester BaseTester */
            $testClass = __NAMESPACE__ . '\\' . $testClass;

            iF(class_exists($testClass)) {
                $tester = new $testClass();
            } else {
                echo $testClass . ' does not exist.';
            }

            $tester->runTests();
        }
    }

    /**
     * Get a list of all demo-test files present in the demo directory
     *
     * @return array
     */
    private static function getAllTests()
    {
        $path = [];
        foreach (FileHelper::findFiles(__DIR__, ['except' => ['BaseTester.php']]) as $file) {
            $key = substr(basename($file), 0, -4);
            $path[$key] = $file;
        }

        return $path;
    }

    /**
     * Run all tests in a file. All methods in the BaseTester should be excluded.
     */
    public function runTests()
    {
//        $this->test['subArray'][] = \Yii::$app->user;
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (in_array($method, ['runAllTests', 'runTests', 'getAllTests', 'writeHeader'])) {
                continue;
            }
            if (in_array($method, $this->skipTests)) {
                continue;
            }
            call_user_func([$this, $method]);
        }
    }

    /**
     * Write a simple line about the test. Usually it is the command itself.
     *
     * @param $header string Title/caption of each test
     */
    protected function writeHeader($header)
    {
        if (php_sapi_name() === 'cli') {
            echo "\n=====\n" . $header . "\n";
        } else {
            echo '<p dir="ltr">' . $header . '</p>';
        }
    }
}
