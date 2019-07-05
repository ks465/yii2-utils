<?php

class UserTableLoginCest
{
    public function _before(FunctionalTester $I)
    {
        /*
         //Set this in test config file to enable testing user by table as main user component
         'user_table' => [
            'class'         => 'khans\utils\models\KHanUser',
            'identityClass' => 'khans\utils\models\UserTable',
            'userTable'     => 'sys_users',
            'loginUrl'      => ['/khan/auth/login'],
            'superAdmins'   => ['keyhan'],
        ],
        //Add this to the test config to enforce login requirement
        'as beforeRequest' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'actions' => ['login', 'error', 'index'], //you need to have a controller and an action site/login
                    'allow' => true, //because this gets called if the user is not logged in and no rule applies.
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
         */
        expect('Make sure test setting is for array based identity model.', Yii::$app->get('user_table')->identityClass)->endsWith('UserTable');
    }

    // tests
    public function tryToWithoutLogin(FunctionalTester $I)
    {
        expect('User is assumed guest', \Yii::$app->get('user_table')->isGuest)->true();
        expect('Guest is not Admin', \Yii::$app->get('user_table')->getIsSuperAdmin())->false();
        expect('$loginUrl is correct', \Yii::$app->get('user_table')->loginUrl)->equals(['/site/login']);

        expect('Can not see front page', \Yii::$app->get('user_table')->can('site/index'))->false();

        $I->amOnRoute('site/about');
        $I->expectTo('See login error');
        $I->cantSee('This is the About page.');
        $I->see('Please fill out the following fields to login:');
    }

    public function tryToAfterLogin(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        expect('Make sure identity class is UserArray', \Yii::$app->get('user_table')->identity)->isInstanceOf('\app\models\UserTable');
        expect('Selected user is Admin', \Yii::$app->get('user_table')->getIsSuperAdmin())->true();
        expect('User is not assumed guest', \Yii::$app->get('user_table')->isGuest)->false();

        $I->amOnRoute('site/about');
        $I->expectTo('Not See login error');
        $I->see('This is the About page.');
        $I->cantSee('Please fill out the following fields to login:');

        expect('about page --login required-- is visible', \Yii::$app->get('user_table')->can('site/about'))->true();

        expect('Any page is accessible', \Yii::$app->get('user_table')->can('AnyPermissionName'))->true();
    }

    public function tryToAfterLogout(FunctionalTester $I)
    {
        expect('Make sure identity class is empty', \Yii::$app->get('user_table')->identity)->null();
        expect('Selected user is Admin', \Yii::$app->get('user_table')->getIsSuperAdmin())->false();
        expect('User is assumed guest', \Yii::$app->get('user_table')->isGuest)->true();

        $I->amOnRoute('site/about');
        $I->expectTo('See login error');
        $I->cantSee('This is the About page.');
        $I->see('Please fill out the following fields to login:');

        expect('about page --login required-- is not visible', \Yii::$app->get('user_table')->can('site/about'))->false();

        expect('No page is accessible', \Yii::$app->get('user_table')->can('AnyPermissionName'))->false();
    }
}
