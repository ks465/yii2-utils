<?php
namespace tests\models;

use khans\utils\models\UserArray as User;

class UserByArrayTest extends \Codeception\Test\Unit
{

    public function testFindUserById()
    {
        expect(User::findIdentity(0))->null();
        expect_not(User::findIdentity(999));
        expect(User::findIdentity(1))->notNull();
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('Sj2jhRfzu3KBSwMaGH4C3lU84Q0hKs9qORL05nit0pt-TnTp8XzYdAEOtbolskVniMLU58gyDDytBkRlfVPGL0ng5wnZVit6No4B1NlMlCLSR-LIn89BUCFjc3lRVuca'));
        expect($user->username)->equals('keyhan');
        expect($user->fullName)->equals('مدیر سیستم');
        expect($user->fullId)->equals('مدیر سیستم (1)');
        expect($user->isSuperAdmin)->true();

        expect_that($user = User::findIdentityByAccessToken('ZI9dhEqteCqSrL35Y6nwwvHOtcMJIbeDBFt1eZFWopjNcGxtxsqJHk7YT53-HVUu5IZeEkyjeZb5JeIizjO_CCqm0HlfMtaHvJV8kV3Cm9g69ejS6VnY3S_HTFSWiXzS'));
        expect($user->username)->equals('system');

        expect_not(User::findIdentityByAccessToken('non-existing'));
        expect_not(User::findIdentityByAccessToken(false));
        expect_not(User::findIdentityByAccessToken(null));
        expect_not(User::findIdentityByAccessToken(true));
    }

    public function testFindUserByUsername()
    {
        expect_that(User::findByUsername('keyhan'));
        expect_that(User::findByUsername('KEYHAN'));
        expect_not(User::findByUsername('SYSTEM'));
        expect_not(User::findByUsername('system'));
        expect_not(User::findByUsername(''));
        expect_not(User::findByUsername(null));
        expect_not(User::findByUsername(false));
        expect_not(User::findByUsername(true));

        expect(User::findByUsername('system'))->null();
    }

    public function testFindUserByEmail()
    {
        expect_that(User::findByUsername('admin@khan.org'));

        expect(User::findByUsername('noreply@khan.org'))->null();
    }

    /**
     *
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('keyhan');
        expect_that($user->validateAuthKey('8T7yYwsOdZVB__L5-RLZuygJ39y0_ltV'));
        expect_not($user->validateAuthKey('test102key'));

        expect($user->validatePassword('123456'))->true();
        expect_not($user->validatePassword(''));
    }

    public function testCreateUser()
    {
        $id = 2;
        $userName = 'testUser';
        $eMail = 'email@khan.org';
        $fullName = 'User Full Name';
        $password = 'test_pass_word';
        $accessToken = false;

        $user = \khans\utils\models\UserArray::createNewUser(compact('id', 'userName', 'eMail', 'fullName', 'password', 'accessToken'));

        expect($user[$id]['password'])->notNull();
        expect($user[$id]['accessToken'])->null();
    }

    public function testHistorySuccess()
    {
        $username = 'success_user_' . time();
        expect(\Yii::getAlias('@runtime/log/user-login.log'))->equals('/var/www/html/khans/runtime/log/user-login.log');
        expect(\khans\utils\models\UserArray::logSuccessLogin($username, 0))->true();
        expect_file(\Yii::getAlias('@runtime/log/user-login.log'))->exists();
        expect_file(\Yii::getAlias('@runtime/log/user-login.log'))->notEmpty();

        $logs =explode("\n", trim(file_get_contents(\Yii::getAlias('@runtime/log/user-login.log'))));
        $lastInsertedLog =explode(',', end($logs));
        expect($lastInsertedLog[0])->equals($username);
    }

    public function testHistoryFail()
    {
        $username = 'fail_user_' . time();
        expect(\khans\utils\models\UserArray::logFailedLogin($username, 0))->true();
        expect_file(\Yii::getAlias('@runtime/log/user-login.log'))->notEmpty();

        $logs =explode("\n", trim(file_get_contents(\Yii::getAlias('@runtime/log/user-login.log'))));
        $lastInsertedLog =explode(',', end($logs));
        expect($lastInsertedLog[0])->equals($username);
    }
}
