<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 12:16
 */


namespace KHanS\Utils\models;


use yii\base\InvalidConfigException;
use yii\web\User;

/**
 * User model
 *
 * @package KHanS\Utils
 * @version 0.3-970803
 * @since   1.0
 *
 * @property integer $id                   شماره کاربر
 * @property string  $username             شناسه کاربر
 * @property string  $email                ایمیل کاربر
 * @property string  $auth_key             کلید تشخیص هویت
 * @property string  $password_hash        رمز گذرواژه
 * @property string  $password_reset_token بلیت بازنشانی گذرواژه
 * @property integer $status               وضعیت فعال بودن کاربر
 * @property integer $create_time           زمان ساخت رکورد کاربر
 * @property integer $update_time           زمان آخرین ویرایش رکورد کاربر
 * @property integer $delete_time           زمان پاک کردن رکورد کاربر از سامانه
 * @property integer $last_visit_time       زمان آخرین ورود کاربر به سامانه
 * @property string  $name                  نام کاربر
 * @property string  $family                نام خانوادگی کاربر
 *
 * @property string  $fullName             نام کامل کاربر
 * @property string  $fullId               نام کامل کاربر و کد شناسایی
 *
 * @property boolean $isSuperAdmin         یک مدیر سیستم است
 */
class KHanUser extends User
{
    /**
     * @var string the class name of the [[KHanIdentity]] object.
     */
    public $identityClass = '\KHanS\Utils\models\KHanIdentity';
    /**
     * @var string name of table containing list of users for this application.
     */
    public $userTable = '';
    /**
     * @var array List of usernames that should be treated as super admins of the site
     */
    public $superAdmins = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->userTable)) {
            throw new InvalidConfigException('userTable is not defined in user component');
        }
        KHanIdentity::setTableName($this->userTable);
        parent::init();
    }

    /**
     * Add extra fields sometimes required
     *
     * @return array
     */
    public function extraFields()
    {
        return ['fullId', 'fullName'];
    }

    /**
     * Get full name of persons from model data
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->identity->fullName;
    }

    /**
     * Get full name of persons from model data along with id number in table
     *
     * @return string
     */
    public function getFullId()
    {
        return $this->identity->fullId;
    }

    /**
     * Returns a value indicating whether the user is an admin.
     *
     * @return bool whether the current user is an admin.
     */
    public function getIsSuperAdmin()
    {
        if ($this->isGuest) {
            return false;
        }

        return $this->identity->getIsSuperAdmin();
    }
}
