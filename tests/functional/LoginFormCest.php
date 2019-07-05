<?php

class LoginFormCest
{

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('system/auth/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('ورود به سامانه', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (keyhan)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByTable(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\khans\utils\models\UserTable::findByUsername('keyhan'));
        $I->amOnPage('/');
        $I->see('Logout (keyhan)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByArray(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\khans\utils\models\UserArray::findByUsername('keyhan'));
        $I->amOnPage('/');
        $I->see('Logout (keyhan)');
    }

    public function loginWithEmptyCredentialsByArray(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_array'));
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('شناسه کاربر نمی‌تواند خالی باشد.');
        $I->see('گذرواژه نمی‌تواند خالی باشد.');
    }

    public function loginWithEmptyCredentialsByTable(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_table'));
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('شناسه کاربر نمی‌تواند خالی باشد.');
        $I->see('گذرواژه نمی‌تواند خالی باشد.');
    }

    public function loginWithWrongCredentialsByArray(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_array'));
        $I->submitForm('#login-form', ['LoginForm[username]' => 'keyhan', 'LoginForm[password]' => 'wrong',]);
        $I->expectTo('see validations errors');
        $I->see('شناسه کاربری یا گذرواژه درست نیست.');
    }

    public function loginWithWrongCredentialsByTable(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_table'));
        $I->submitForm('#login-form', ['LoginForm[username]' => 'keyhan', 'LoginForm[password]' => 'wrong',]);
        $I->expectTo('see validations errors');
        $I->see('شناسه کاربری یا گذرواژه درست نیست.');
    }

    public function loginSuccessfullyByArray(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_array'));
        $I->submitForm('#login-form', ['LoginForm[username]' => 'keyhan', 'LoginForm[password]' => '123456',]);
        $I->dontSeeElement('form#login-form');
        $I->see('Logout (keyhan)');
    }

    public function loginSuccessfullyByTable(\FunctionalTester $I)
    {
        Yii::$app->set('user', Yii::$app->get('user_table'));
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'keyhan',
            'LoginForm[password]' => '123456',
//             'LoginForm[verifyCode]' => 'testme',
        ]);
        $I->dontSeeElement('form#login-form');
        $I->see('Logout (keyhan)');
    }

    public function loginSuccessfullyByTable1(\FunctionalTester $I) {
        $form = [
            'LoginForm[username]' => '',
            'LoginForm[password]' => '',
        ];
        $I->seeInFormFields('#login-form', $form);;
    }
}