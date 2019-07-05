<?php

namespace khans\utils\tools\models;

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
class SysUsers extends \khans\utils\models\UserTable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['username', 'auth_key', 'password_hash', 'name', 'family', 'email', 'create_time'], 'required'],
            [['status', 'last_visit_time', 'create_time', 'update_time', 'delete_time'], 'integer'],
            [['username', 'name', 'email'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 40],
            [['password_hash', 'password_reset_token', 'access_token'], 'string', 'max' => 255],
            [['family'], 'string', 'max' => 128],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['access_token'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'شناسه کاربر',
            'auth_key' => 'کلید شناسایی',
            'password_hash' => 'گذرواژه رمز شده',
            'password_reset_token' => 'توکن بازیابی گذرواژه',
            'access_token' => 'توکن دسترسی',
            'name' => 'نام کاربر',
            'family' => 'نام خانوادگی کاربر',
            'email' => 'ایمیل کاربر',
            'status' => 'وضعیت کاربر',
            'last_visit_time' => 'آخرین زمان دسترسی',
            'create_time' => 'زمان ثبت نام',
            'update_time' => 'زمان آخرین ویرایش',
            'delete_time' => 'زمان پاک شدن از سامانه',
        ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysUsersQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new queries\SysUsersQuery(get_called_class());
    }
}
