<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 12:16
 */


namespace khans\utils\models;


use khans\utils\components\StringHelper;
use mdm\admin\components\Configs;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\conditions\AndCondition;
use yii\db\conditions\OrCondition;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User Identity model holds required parts for Yii::$app->user->identity
 *
 *
 * @property string  $fullName             read-only نام کامل کاربر
 * @property string  $name                 نام کاربر
 * @property string  $family               نام خانوادگی کاربر
 * @property string  $gender               جنسیت کاربر
 * @property integer $id                   شناسه کاربر
 * @property string  $password_hash        رمز گذرواژه
 * @property string  $password_reset_token بلیت بازنشانی گذرواژه
 * @property string  $access_token         کلید دسترسی خودکار
 * @property string  $email                ایمیل کاربر
 * @property string  $auth_key             کلید تشخیص هویت
 * @property string  $password             write-only password گذرواژّ کاربر
 *
 * @property boolean $isSuperAdmin         یک مدیر سیستم است
 *
 * @package khans\utils\models
 * @version 0.3.1-970803
 * @since   1.0
 */
class KHanIdentity extends KHanModel implements IdentityInterface
{
    /**
     * the user has leaved the duties in the site. It is required only to reference older data.
     */
    const STATUS_RETIRED = 2;
    /**
     * @var string name of table holding the user data
     */
    private static $_tableName = 'sys_user';
    /**
     * @var boolean if the user's username is in the superAdmins configuration of the user component
     */
    private $_isSuperAdmin = null;

    /**
     * @param string $tableName
     */
    public static function setTableName($tableName)
    {
        static::$_tableName = $tableName;
    }

    /**
     * Finds user by email -- email is used as username
     *
     * @param string $username
     *
     * @return KHanIdentity|null
     */
    public static function findByUsername($username)
    {
        $lookupItems = new OrCondition([
            ['username' => $username],
            ['email' => $username],
        ]);
        $condition = new AndCondition([
            $lookupItems,
            'status' => static::STATUS_ACTIVE,
        ]);

        return static::findOne($condition);
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
     * get list of available statuses defined.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return parent::getStatuses() + [static::STATUS_RETIRED => 'بازنشسته'];
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
     * Returns whether the logged in user is an administrator.
     *
     * @return boolean the result.
     */
    public function getIsSuperAdmin()
    {
        if ($this->_isSuperAdmin !== null) {
            return $this->_isSuperAdmin;
        }

        try {
            $this->_isSuperAdmin = in_array($this->username, Yii::$app->get('user')->superAdmins);
        } catch (InvalidConfigException $e) {
            return false;
        }

        return $this->_isSuperAdmin;
    }

    /**
     * Get id of this identity which is equal to primary key of the table
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Find identity model
     *
     * @param integer $id user id
     *
     * @return KHanIdentity|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token.
     *
     * @return KHanIdentity
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * get full name of persons from model data
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->family;
    }

    /**
     * Get full name of persons from model data along with id number in table
     *
     * @return string
     */
    public function getFullId()
    {
        return $this->fullName . ' (' . $this->id . ')';
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
     * Generates new access token
     *
     * @throws \yii\base\Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(128);
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Get list of recorded login tryings for the given user
     */
    public function getLoginHistory()
    {
        return $this->hasMany(KHanLoginHistory::className(), ['id' => 'user_id', 'user_table' => self::tableName()]);
    }

    /**
     * Get name of table containing list of users for this application.
     * @return string
     */
    public static function tableName()
    {
        return static::$_tableName;
    }


    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     *
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[KHanUser::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     * Add timestamp, blameable and record-login behavior to inhabitant
     */
    public function behaviors()
    {
        return [
            'timestamp'    => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    KHanIdentity::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    KHanIdentity::EVENT_BEFORE_UPDATE => 'update_time',
                    KHanIdentity::EVENT_BEFORE_DELETE => 'delete_time',
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
     * Return validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'name', 'family', 'email', 'auth_key', 'password_hash'], 'required'],
            [['username', 'id', 'password_reset_token'], 'unique'],
            ['username', 'string', 'min' => 6, 'max' => 63],
            ['status', 'default', 'value' => KHanIdentity::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(KHanIdentity::getStatuses())],

            [['email', 'name', 'family'], 'required'],
            [['username', 'email', 'family', 'name'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['username', 'password_hash', 'name'], 'string', 'length' => [3, 63]],
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

    /**
     * @return array list of KHanIdentity scenarios
     * @return array
     */
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
     * Return labels for the model
     *
     * @return array
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
