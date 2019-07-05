<?php


namespace tests\models;

use Yii;
use app\models\system\LoginForm;
//TODO Change the LoginForm model to revised one
use khans\utils\models\UserArray;

class LoginFormTest extends \Codeception\Test\Unit
{

    /**
     * Data for mocking LoginForm object to use table-based user identity class
     *
     * @var array
     */
    private $tableModel;

    /**
     * Data for mocking LoginForm object to use array-based user identity class
     *
     * @var array
     */
    private $arrayModel;

    public function _before()
    {
        // \khans\utils\models\UserTable::setTableName('sys_users');
        $this->tableModel = ['username' => 'keyhan', 'password' => 'admin', '_user' => \khans\utils\models\UserTable::findByUsername('keyhan'),];

        $this->arrayModel = ['username' => 'keyhan', 'password' => '123456', '_user' => \khans\utils\models\UserArray::findByUsername('keyhan'),];
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUserArray()
    {
        $model = $this->construct(new LoginForm(), [], array_merge($this->arrayModel, ['username' => 'not_existing_username', 'password' => 'not_existing_password']));

        expect($model->login())->false();
        expect(\Yii::$app->user->isGuest)->true();
        expect($model->errors)->hasKey('password');
    }

    public function testLoginWrongPasswordArray()
    {
        $model = $this->construct(new LoginForm(), [], array_merge($this->arrayModel, ['password' => 'wrong_password']));

        expect_not($model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($model->errors)->hasKey('password');
    }

    public function testLoginCorrectArray()
    {
        $model = $this->construct(new LoginForm(), [], $this->arrayModel);

        expect($model->login())->true();
        expect(\Yii::$app->user->isGuest)->false();
        expect($model->errors)->hasntKey('password');
        expect($model->errors)->count(0);
        expect(\Yii::$app->user->getIdentity())->equals(\khans\utils\models\UserArray::findOne(1));
    }

    public function testLoginNoUserTable()
    {
        $model = $this->construct(new LoginForm(), [], array_merge($this->tableModel, ['username' => 'not_existing_username', 'password' => 'not_existing_password']));

        expect($model->login())->false();
        expect(\Yii::$app->user->isGuest)->true();
        expect($model->errors)->hasKey('password');
    }

    public function testLoginWrongPasswordTable()
    {
        $model = $this->construct(new LoginForm(), [], array_merge($this->tableModel, ['password' => 'wrong_password']));

        expect($model->login())->false();
        expect(\Yii::$app->user->isGuest)->true();
        expect($model->errors)->hasKey('password');
    }

    public function testLoginCorrectTable()
    {
        $model = $this->construct(new LoginForm(), [], $this->tableModel);

        expect($model->login())->true();
        expect(\Yii::$app->user->isGuest)->false();
        expect($model->errors)->hasntKey('password');
        expect($model->errors)->count(0);
        expect(\Yii::$app->user->getIdentity())->equals(\khans\utils\models\UserTable::findOne(1));
    }
}
