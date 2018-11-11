<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 12:16
 */


namespace KHanS\Utils\models;


use KHanS\Utils\components\StringHelper;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @package KHanS\Utils
 * @version 0.3-970803
 * @since   1.0
 *
 * @property string  $fullName             read-only نام کامل کاربر
 * @property string  $name                 نام کاربر
 * @property string  $family               نام خانوادگی کاربر
 * @property string  $gender               جنسیت کاربر
 * @property integer $id                   شناسه کاربر
 * @property string  $password_hash        رمز گذرواژه
 * @property string  $password_reset_token بلیت بازنشانی گذرواژه
 * @property string  $email                ایمیل کاربر
 * @property string  $auth_key             کلید تشخیص هویت
 * @property string  $password             write-only password گذرواژّ کاربر
 */
class KHanUserIdentity extends KHanModel implements IdentityInterface
{
    /**
     * the user has leaved the duties in the site. It is required only to reference older data.
     */
    const STATUS_RETIRED = 2;

    /**
     * get list of available statuses defined.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return parent::getStatuses() + [KHanUser::STATUS_RETIRED => 'بازنشسته'];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Finds user by email -- email is used as username
     *
     * @param string $email
     *
     * @return static|null
     */
    public static function findByUsername($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * get full name of persons from model data
     *
     * @return string
     */
    public function getFullName()
    {
        return ArrayHelper::getValue($this, 'name', 'نامشخص') . ' ' .
            ArrayHelper::getValue($this, 'family', 'نامشخص');
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     *
     */
    public function getLoginHistory()
    {
        return $this->hasMany(UsersLogins::className(), ['id' => 'user_id', 'user_table' => self::tableName()]);
    }    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        $module = Yii::$app->getModule('khan');
        if (empty($module)) {
            return '{{%user}}';
        }

        return $module->tableMap['User'];
    }    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp'    => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    KHanUser::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    KHanUser::EVENT_BEFORE_DELETE => 'delete_time',
                ],
                'value'      => function() {
                    return new Expression('CURRENT_TIMESTAMP');
                },
            ],
            'record-login' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\web\User::EVENT_AFTER_LOGIN => ['last_login_time'],
                ],
                'value'      => function() {
                    return new Expression('CURRENT_TIMESTAMP');
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'family', 'email', 'auth_key', 'password_hash'], 'required'],
            [['username', 'id', 'password_reset_token'], 'unique'],
            ['username', 'string', 'min' => 6, 'max' => 63],
            ['status', 'default', 'value' => KHanUser::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(KHanUser::getStatuses())],

            [['email', 'name', 'family'], 'required'],
            [['username', 'email', 'family', 'name'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['username', 'password', 'name'], 'string', 'length' => [3, 63]],
            [
                ['family', 'email', 'password_hash', 'access_token', 'password_reset_token'], 'string',
                'length' => [2, 128],
            ],
            [
                ['name', 'family'],
                'match',
                'pattern' => '/[0-9\x{06F0}-\x{06F9}]/u',
                'not'     => true,
                'message' => '{attribute} نمی‌تواند شامل اعداد باشد',
            ],
            [
                ['name', 'family'],
                'match',
                'pattern' => StringHelper::PERSIAN_NAME,
                'message' => '{attribute} بایستی به فارسی باشد',
            ],
            [['id', 'status', 'create_time', 'update_time', 'last_login_time', 'delete_time'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            ['email', 'exist', 'message' => 'There is no user with such email.', 'on' => 'requestPasswordResetToken'],
        ];
    }

    public function scenarios()
    {
        return [
                'profile'                   => ['username', 'email', 'password_hash', 'password'],
                'resetPassword'             => ['password_hash'],
                'requestPasswordResetToken' => ['email'],
                'login'                     => ['last_visit_time'],
            ] + parent::scenarios();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'شناسه کاربر',
            'fullName' => 'نام و نام خانوادگی',
            'name'     => 'نام',
            'family'   => 'نام خانوادگی',
            'email'    => 'نشانی الکترونیکی',
            'status'   => 'وضعیت کاربر',
        ];
    }




}