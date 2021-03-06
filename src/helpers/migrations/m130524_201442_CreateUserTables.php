<?php


namespace khans\utils\helpers\migrations;

use khans\utils\models\KHanIdentity;
use mdm\admin\components\Configs;
use yii\helpers\Console;


/**
 * Class m130524_201442_CreateUserTables creates User table for the given application
 *
 * @package KHanS\Utils
 * @version 0.3.2-970804
 * @since   1.0
 */
class m130524_201442_CreateUserTables extends KHanMigration
{
    /**
     * remove th user table
     */
    public function safeDown()
    {
        $userTable = Configs::instance()->userTable;

        $this->dropTable($userTable);
    }

    /**
     * create user table for the application
     *
     * @throws \yii\console\Exception
     */
    public function safeUp()
    {
        $userTable = Configs::instance()->userTable;

        $this->createUserTable($userTable, 'Generic User Login Table');

        try {
            $this->insertAdminUser($userTable);
        } catch (\yii\base\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Create user table
     *
     * @param string $tableName name of table used for holding users data
     * @param string $tableComment comment of the table
     */
    protected function createUserTable($tableName, $tableComment)
    {
        $this->createTable($tableName, [
            'id'       => $this->primaryKey(),
            'username' => $this->string(64)->notNull()->unique()->comment('شناسه کاربر'),

            'auth_key'             => $this->string(40)->notNull()->comment('کلید شناسایی'),
            'password_hash'        => $this->string()->notNull()->comment('گذرواژه رمز شده'),
            'password_reset_token' => $this->string()->unique()->comment('توکن بازیابی گذرواژه'),

            'access_token' => $this->string()->unique()->comment('توکن دسترسی'),

            'name'   => $this->string(64)->notNull()->comment('نام کاربر'),
            'family' => $this->string(128)->notNull()->comment('نام خانوادگی کاربر'),
            'email'  => $this->string(64)->notNull()->unique()->comment('ایمیل کاربر'),

            'status'          => $this->smallInteger()->notNull()->defaultValue(KHanIdentity::STATUS_ACTIVE)->comment('وضعیت کاربر'),
            'last_visit_time' => $this->bigInteger()->comment('آخرین زمان دسترسی'),
            'create_time'     => $this->bigInteger()->notNull()->comment('زمان ثبت نام'),
            'update_time'     => $this->bigInteger()->comment('زمان آخرین ویرایش'),
            'delete_time'     => $this->bigInteger()->comment('زمان پاک شدن از سامانه'),
        ], $this->comment($tableComment));
    }

    /**
     * Write the system user for situations that the actor is automatic script.
     *
     * @param string $tableName name of table
     *
     * @throws \yii\base\Exception
     */
    protected function insertSystemUser($tableName)
    {
        /* @var KHanIdentity $systemUser */
        KHanIdentity::setTableName($tableName);
        $systemUser = new KHanIdentity();

        $systemUser->setAttributes([
            'username'      => 'SYSTEM',
            'auth_key'      => '!',
            'password_hash' => '~!~',
            'name'          => 'سامانه',
            'family'        => 'خودکار',
            'email'         => 'noreply@khan.org',
            'status'        => KHanIdentity::STATUS_DISABLED,
        ], false);
        $systemUser->generateAccessToken();

        if (!$systemUser->save(false)) {
            throw new \yii\base\Exception('Error when creating system user:' . $systemUser->getFirstErrors());
        }
        $systemUser->setAttribute('id', 0);
        $systemUser->save(false);

        Console::stdout('System user created successfully for ' . $tableName . PHP_EOL);
    }

    /**
     * Write the very first user --admin-- in each user model created.
     *
     * @param string $tableName name of table
     *
     * @throws \yii\base\Exception
     */
    protected function insertAdminUser($tableName)
    {
        /* @var KHanIdentity $adminUser */
        KHanIdentity::setTableName($tableName);
        $adminUser = new KHanIdentity();

        Console::stdout('Please type the admin user info for ' . $tableName . ':' . PHP_EOL);
        $this->readStdIn('Type Name', $adminUser, 'name', 'مدیر');
        $this->readStdIn('Type Family', $adminUser, 'family', 'سیستم');

        $this->readStdIn('Email (e.g. admin@mydomain.com)', $adminUser, 'email', 'admin@khan.org');

        $this->readStdIn('Type Username', $adminUser, 'username', 'keyhan');
        $this->readStdIn('Type Password', $adminUser, 'password_hash', 'admin');

        $adminUser->status = KHanIdentity::STATUS_ACTIVE;
        $adminUser->generateAuthKey();
        $adminUser->generateAccessToken();
        $adminUser->setPassword($adminUser->password_hash);

        if (!$adminUser->save(false)) {
            throw new \yii\base\Exception('Error when creating admin user:' . $adminUser->getFirstErrors());
        }

        Console::stdout('User created successfully for ' . $tableName . PHP_EOL);
    }
}
