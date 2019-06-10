<?php
namespace tests\models;

use khans\utils\models\ {
    KHanUser,
    UserArray,
    UserTable
};

class KHanUserTest extends \Codeception\Test\Unit
{

    /**
     *
     * @var app\models\UserArray
     */
    private $identityArray;

    /**
     *
     * @var app\models\UserTable
     */
    private $identityTable;

    /**
     *
     * @var app\models\KHanUser
     */
    private $userArray;

    /**
     *
     * @var app\models\KHanUser
     */
    private $userTable;

    /**
     *
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->identityArray = UserArray::findOne(1);
        $this->identityTable = UserTable::findOne(1);

        $this->userArray = new KHanUser([
            'identityClass' => '\khans\utils\models\UserArray'
        ]);
        $this->userTable = new KHanUser([
            'identityClass' => '\khans\utils\models\UserTable',
            'userTable' => 'sys_users'
        ]);

        $this->userArray->setIdentity($this->identityArray);
        $this->userTable->setIdentity($this->identityTable);
    }

    protected function _after()
    {
        $this->userArray->logout();
        $this->userTable->logout();
    }

    // tests
    public function testIdentityClass()
    {
        expect('app\models\UserArray')->regExp('/User(Array|Table)/');
        expect($this->userArray->identityClass)->regExp('/User(Array|Table)/');

        expect('app\models\UserTable')->regExp('/User(Array|Table)/');
        expect($this->userTable->identityClass)->regExp('/User(Array|Table)/');
    }

    public function testLoginUrl()
    {
        expect($this->userArray->loginUrl)->equals([
            '/khan/auth/login'
        ]);

        expect($this->userTable->loginUrl)->equals([
            '/khan/auth/login'
        ]);
    }

    public function testReturnUrl()
    {
        $this->userArray->setReturnUrl('dummy/test/path');
        expect($this->userArray->getReturnUrl())->equals('dummy/test/path');

        $this->userTable->setReturnUrl('dummy/test/path');
        expect($this->userTable->getReturnUrl())->equals('dummy/test/path');
    }

    public function testGetIdentityDetails()
    {
        expect($this->userArray->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userArray->getId())->equals(1);
        expect($this->userArray->fullName)->equals('مدیر سیستم');
        expect($this->userArray->isGuest)->false();

        expect($this->userTable->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userTable->getId())->equals(1);
        expect($this->userTable->fullName)->equals('مدیر سیستم');
        expect($this->userTable->isGuest)->false();
    }

    public function testInstanceOfIdentity()
    {
        expect($this->userArray->identity)->notNull();
        expect($this->userArray->identity instanceof \khans\utils\models\UserArray)->true();
        expect($this->userArray->identity instanceof \khans\utils\models\UserTable)->false();

        expect($this->userTable->identity)->notNull();
        expect($this->userTable->identity instanceof \khans\utils\models\UserTable)->true();
        expect($this->userTable->identity instanceof \khans\utils\models\UserArray)->false();
    }

    public function testLogout()
    {
        $this->userArray->logout();
        $this->userTable->logout();

        expect($this->userArray->getIdentity())->null();
        expect($this->userArray->isGuest)->true();

        expect($this->userTable->getIdentity())->null();
        expect($this->userTable->isGuest)->true();
    }

    /**
     *
     * @depends testLogout
     */
    public function testLogin()
    {
        $this->userArray->logout();
        $this->userTable->logout();

        $this->userArray->login($this->identityArray);
        $this->userTable->login($this->identityTable);

        expect($this->userArray->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userArray->getId())->equals(1);
        expect($this->userArray->fullName)->equals('مدیر سیستم');
        expect($this->userArray->isGuest)->false();

        expect($this->userTable->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userTable->getId())->equals(1);
        expect($this->userTable->fullName)->equals('مدیر سیستم');
        expect($this->userTable->isGuest)->false();
    }

    /**
     *
     * @depends testLogout
     */
    function testLoginByNonValidAccessToken()
    {
        $this->userArray->logout();
        $this->userTable->logout();

        $this->userArray->loginByAccessToken('non-existent-access-token');
        $this->userTable->loginByAccessToken('non-existent-access-token');

        expect($this->userArray->getIdentity())->null();
        expect($this->userArray->isGuest)->true();

        expect($this->userTable->getIdentity())->null();
        expect($this->userTable->isGuest)->true();
    }

    /**
     *
     * @depends testLogout
     */
    public function testLoginByValidAccessToken()
    {
        $this->userArray->logout();
        $this->userTable->logout();
        $this->userArray->loginByAccessToken($this->identityArray->accessToken);
        $this->userTable->loginByAccessToken($this->identityTable->access_token);

        expect($this->userArray->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userArray->getId())->equals(1);
        expect($this->userArray->fullName)->equals('مدیر سیستم');
        expect($this->userArray->isGuest)->false();

        expect($this->userTable->getIdentity()->fullName)->equals('مدیر سیستم');
        expect($this->userTable->getId())->equals(1);
        expect($this->userTable->fullName)->equals('مدیر سیستم');
        expect($this->userTable->isGuest)->false();
    }

    public function testAccessChecker()
    {
        expect($this->userArray->accessChecker)->notNull();
        expect($this->userArray->accessChecker instanceof \khans\utils\rbac\AccessCheckerArray)->true();
        expect($this->userArray->accessChecker instanceof \khans\utils\rbac\AccessCheckerTable)->false();
        expect($this->userArray->accessChecker instanceof \yii\rbac\DbManager)->false();

        expect($this->userTable->accessChecker)->notNull();
        expect($this->userTable->accessChecker instanceof \khans\utils\rbac\AccessCheckerTable)->true();
        expect($this->userTable->accessChecker instanceof \khans\utils\rbac\AccessCheckerArray)->false();
        expect($this->userTable->accessChecker instanceof \yii\rbac\DbManager)->false();
    }
}