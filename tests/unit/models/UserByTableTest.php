<?php
namespace tests\models;

use khans\utils\models\UserTable as User;

class UserByTableTest extends \Codeception\Test\Unit
{

    public function _before()
    {
        User::setTableName('sys_users');
        \Yii::$app->set('user', \Yii::$app->get('user_table'));
    }

    public function testFindUserById()
    {
        expect(User::findIdentity(0))->null();
        expect_not(User::findIdentity(999));
        expect(User::findIdentity(2))->notNull();
        expect(User::findIdentity(102))->notNull();

        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('keyhan');
        expect($user->fullName)->equals('مدیر سیستم');
        expect($user->fullId)->equals('مدیر سیستم (1)');
        expect($user->isSuperAdmin)->true();
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('sOwNroavVx_c0sdLGyt-8mKlQp6m-6WHiPBnbUkDSMPXvygmqfbvoXFTI20V0QoM9OpXL_rchBXs-pYHu2KoJfbAKZQ-Tpvgdlt9bV514dS7aufO49qso2lD1rpg1doU'));
        expect($user->username)->equals('keyhan');
        expect($user->fullName)->equals('مدیر سیستم');
        expect($user->fullId)->equals('مدیر سیستم (1)');
        expect($user->isSuperAdmin)->true();

        expect_that($user = User::findIdentityByAccessToken('qr8rVXBccARsklEwEQlBt5_jIcQJDyILj29oKafC7KAxNSTc7tt7s88dC8RATTHK-QaqokJpvZifyDunS_s88y87yDnSkIeC0UkCzKwQ9pCG6TTZ-Nw2QUyo78LpF6Ed'));
        expect($user->username)->equals('pgrad.rest.client');

        expect_not(User::findIdentityByAccessToken('non-existing'));
        expect_not(User::findIdentityByAccessToken('Hg26ioiBnUenRjE8HJmELMIH669B7t7jdxkWso3TC-syVEf5ViWcWz2G6T44zKfcP0TZjTe6E0XrJRs_KB6x1XtYZf5ixb4EDQJsuq8g4hxF76NqzPT8L6FcbKJmAtDA'));
        expect_not(User::findIdentityByAccessToken(false));
        expect_not(User::findIdentityByAccessToken(null));
        expect_not(User::findIdentityByAccessToken(true));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('keyhan'));
        expect(User::findByUsername('system'))->null();
        expect(User::findByUsername('SYSTEM'))->null();

        expect(User::findByUsername('استاد سه.استادها'))->notNull();
        expect(User::findByUsername('fac.2@khan.org'))->notNull();

        expect(User::findByUsername('pgrad.rest.client'));

        expect_not(User::findByUsername(''));
        expect_not(User::findByUsername(null));
        expect_not(User::findByUsername(false));
        expect_not(User::findByUsername(true));
    }

    /**
     *
     * @depends testFindUserByUsername
     */
    public function testValidateAdminUser()
    {
        $user = User::findByUsername('keyhan');
        expect($user->validateAuthKey('s2ICLJTS76Lh6xvnuXyhEbTG9NRdjAai'))->true();

        expect($user->validatePassword('admin'))->true();

        expect(User::findByUsername('system'))->null();
    }

    /**
     *
     * @depends testFindUserByUsername
     */
    public function testValidateRestClient()
    {
        expect_that($user = User::findByUsername('pgrad.aut.ac.ir@khan.org'));
        expect($user->validateAuthKey('kjJFmQjJfnTh0gSXVkKK8_T2m3wjOMYU'))->true();
    }

    /**
     *
     * @depends testFindUserByUsername
     */
    public function testValidateNormalUser()
    {
        $user = User::findByUsername('استاد سه.استادها');
        expect($user->validateAuthKey('h_louAMriIvOllrnpwJIPLFWLRrsx9o5'))->true();

        expect($user->validatePassword('123456'))->true();
    }

//     public function testHistorySuccess()
//     {
//         $username = 'success_user_' . time();

//         expect(\khans\utils\models\UserTable::logSuccessLogin($username, 0))->true();
//     }

//     public function testHistoryFail()
//     {
//         $username = 'fail_user_' . time();
//         expect(\khans\utils\models\UserTable::logFailedLogin($username, 0))->true();
//     }
}
