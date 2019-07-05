<?php

namespace khans\utils\demos\data;

use Yii;

/**
 * This is the model class for table "sys_users_staff".
 *
 * @property int $id
 * @property string $username شناسه کاربر
 * @property string $auth_key کلید شناسایی
 * @property string $password_hash گذرواژه رمز شده
 * @property string $password_reset_token توکن بازیابی گذرواژه
 * @property string $access_token توکن دسترسی
 * @property string $name نام کاربر
 * @property string $family نام خانوادگی کاربر
 * @property string $email ایمیل کاربر
 * @property int $status وضعیت کاربر
 * @property int $last_visit_time آخرین زمان دسترسی
 * @property int $create_time زمان ثبت نام
 * @property int $update_time زمان آخرین ویرایش
 * @property int $delete_time زمان پاک شدن از سامانه
 *
 * @package KHanS\Utils
 * @version 0.1.1-971030
 * @since   1.0
 */
class SysUsers  extends \khans\utils\tools\models\SysUsers
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('test');
    }
}