<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 12:16
 */


namespace khans\utils\models;


use khans\utils\components\Jalali;
use khans\utils\components\StringHelper;
use khans\utils\tools\models\SysHistoryUsers;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\conditions\{AndCondition, OrCondition};
use yii\web\IdentityInterface;

/**
 * User Identity model holds required parts for Yii::$app->user->identity
 *
 * @property integer $id                   شماره کاربر
 * @property string  $username             شناسه کاربر
 * @property string  $auth_key             کلید تشخیص هویت
 * @property string  $password_hash        رمز گذرواژه
 * @property string  $password_reset_token بلیت بازنشانی گذرواژه
 * @property string  $access_token         کلید دسترسی خودکار
 * @property string  $name                  نام کاربر
 * @property string  $family                نام خانوادگی کاربر
 * @property string  $email                ایمیل کاربر
 * @property integer $status               وضعیت فعال بودن کاربر
 * @property integer $last_visit_time       زمان آخرین ورود کاربر به سامانه
 * @property integer $create_time           زمان ساخت رکورد کاربر
 * @property integer $update_time           زمان آخرین ویرایش رکورد کاربر
 * @property integer $delete_time           زمان پاک کردن رکورد کاربر از سامانه
 * @property string  $fullName             نام کامل کاربر
 * @property string  $fullId               نام کامل کاربر و کد شناسایی
 * @property boolean $isSuperAdmin         یک مدیر سیستم است
 *
 * @package khans\utils\models
 * @version 0.3.4-970928
 * @since   1.0
 */
class KHanIdentity extends KHanModel implements IdentityInterface
{
    /**
     * This user can not log in or be used in any other rules than automated procedures.
     */
    const STATUS_DISABLED = 1;
    /**
     * The user has leaved the duties in the site. It is required only to reference older data.
     */
    const STATUS_RETIRED = 3;
    /**
     * @var string name of table holding the user data
     */
    private static $_tableName = 'sys_user';
    /**
     * @var string classname of the table for logging failed or successful login attempts
     */
    private static $_loginHistoryClass = 'khans\utils\tools\models\SysHistoryUsers';
    /**
     * @var boolean if the user's username is in the superAdmins configuration of the user component
     */
    private $_isSuperAdmin = null;

    //<editor-fold Desc="Finders">

    /**
     * Finds user by email -- email is used as username
     *
     * @param string $username
     *
     * @return KHanIdentity|null|\yii\db\ActiveRecord
     */
    public static function findByUsername($username): ?KHanIdentity
    {
        $lookupItems = new OrCondition([
            ['username' => $username],
            ['email' => $username],
        ]);
        $condition = new AndCondition([
            ['status' => static::STATUS_ACTIVE],
            $lookupItems,
        ]);

        return static::find()->where($condition)->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return KHanIdentity|null
     */
    public static function findByPasswordResetToken($token): ?KHanIdentity
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
    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);

        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * Find identity model
     *
     * @param integer $id user id
     *
     * @return KHanIdentity|null
     */
    public static function findIdentity($id): ?KHanIdentity
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
//    </editor-fold>

    //<editor-fold Desc="Getters">
    /**
     * Finds an identity by the given token.
     * This method is only applicable for a REST server ran using [[rest\controllers\RestController]]
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token.
     *
     * @return KHanIdentity
     */
    public static function findIdentityByAccessToken($token, $type = null): KHanIdentity
    {
//        throw new \Exception('attach to database table');
//        if (Authenticate::unlock($token)) {
//            return new static([
//                'id'          => '0',
//                'username'    => 'system',
//                'password'    => 'system',
//                'authKey'     => 'as_per_token',
//                'accessToken' => 'system-token',
//            ]);
//        }

        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Get id of this identity which is equal to primary key of the table
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Write data about a successful login attempt from valid user
     *
     * @param string  $username string used as username or email for login
     * @param integer $attempts number of attempts to login
     *
     * @return bool result of saving the log
     */
    public static function logSuccessLogin($username, $attempts): bool
    {
        return self::saveLogin($username, Yii::$app->user->id, SysHistoryUsers::LOGIN_SUCCESSFUL, $attempts);
    }

    /**
     * Write data about a failed login attempt from any user --either known or unknown.
     *
     * @param string  $username string used as username or email for login
     * @param integer $attempts number of attempts to login
     *
     * @return bool result of saving the log
     */
    public static function logFailedLogin($username, $attempts)
    {
        return self::saveLogin($username, 'X', SysHistoryUsers::LOGIN_FAILED, $attempts);
    }

    /**
     * Write data about a login event built by other methods
     *
     * @param string  $username string used as username or email for login
     * @param string  $userID user ID for the logged in user set by the other methods
     * @param integer $result result of login method of the [[KHanUser]] class
     * @param integer $attempts number of attempts to login
     *
     * @see logSuccessLogin
     * @see logFailedLogin
     * @see SysHistoryUsers
     * @return bool result of saving the log
     */
    private static function saveLogin($username, $userID, $result, $attempts): bool
    {
        $time = time();
        /* @var $logger KHanModel */
        $logger = new static::$_loginHistoryClass();
        $logger->setAttributes([
            'username'   => $username,
            'user_id'    => (string)$userID,
            'timestamp'  => $time,
            'date'       => Jalali::date('Y/m/d', $time),
            'time'       => Jalali::date('H:i:s', $time),
            'user_table' => static::$_tableName,
            'result'     => $result,
            'attempts'   => $attempts,
            'ip'         => Yii::$app->request->getUserIP(),
        ]);

        return $logger->save();
    }


    /**
     * @param string $tableName
     */
    public static function setTableName($tableName)
    {
        static::$_tableName = $tableName;
    }
//    </editor-fold>

    //<editor-fold Desc="Generators">
    /**
     * Returns whether the logged in user is an administrator.
     *
     * @return boolean the result.
     */
    public function getIsSuperAdmin(): bool
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
     * get full name of persons from model data
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->name . ' ' . $this->family;
    }

    /**
     * Get full name of persons from model data along with id number in table
     *
     * @return string
     */
    public function getFullId(): string
    {
        return $this->fullName . ' (' . $this->id . ')';
    }

    /**
     * Generates new password reset token
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new access token
     *
     * @throws \yii\base\Exception
     */
    public function generateAccessToken(): void
    {
        $this->access_token = Yii::$app->security->generateRandomString(128);
    }

    /**
     * Get name of table containing list of users for this application.
     *
     * @return string
     */
    public static function tableName(): string
    {
        return static::$_tableName;
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     * Add timestamp, record-login behavior to inhabitant
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    KHanIdentity::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    KHanIdentity::EVENT_BEFORE_UPDATE => ['update_time'],
                    KHanIdentity::EVENT_BEFORE_DELETE => ['delete_time'],
                ],
            ],
        ];
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Return validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'name', 'family', 'email', 'auth_key'], 'required'],

            [['username', 'id', 'password_reset_token'], 'unique'],
            ['username', 'string', 'min' => 6, 'max' => 63],
            ['password_hash', 'default', 'value' => '!'],
            ['status', 'default', 'value' => KHanIdentity::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(KHanIdentity::getStatuses())],

            [['username', 'email', 'family', 'name'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['username', 'name', 'family', 'email'], 'string', 'length' => [3, 63]],
            [['password_hash', 'access_token', 'password_reset_token'], 'string', 'length' => [0, 128],],
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
            [['id', 'status', 'create_time', 'update_time', 'last_visit_time', 'delete_time'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            ['email', 'exist', 'message' => 'کاربری با این ایمیل شناخته نشد.', 'on' => 'requestPasswordResetToken'],
        ];
    }
//</editor-fold>

//<editor-fold Desc="Setters">
    /**
     * get list of available statuses defined.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return parent::getStatuses() + [
                static::STATUS_DISABLED => 'غیرمجاز',
                static::STATUS_RETIRED  => 'بازنشسته',
            ];
    }

    /**
     * @return array list of KHanIdentity scenarios
     * @return array
     */
    public function scenarios(): array
    {
        return [
                'profile'       => ['username', 'email', 'name', 'family', 'password_hash', 'auth_key', 'status',],
                'resetPassword' => ['password_hash', 'access_token', /*'password_reset_token'*/],
//                'requestPasswordResetToken' => ['email'],
                'login'         => ['last_visit_time'],
            ] + parent::scenarios();
    }

    /**
     * Return labels for the model
     *
     * @return array
     */
    public function attributeLabels(): array
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
//</editor-fold>

//<editor-fold Desc="Validators">

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            $this->generateAuthKey();
        }

        return parent::beforeSave($insert);
    }

    /**
     * Generates "remember me" authentication key
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates the given auth key.
     * This is required if [[KHanUser::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }
//</editor-fold>

//<editor-fold Desc="Default Model">
    /**
     * Get list of recorded login attempts for the user
     */
    public function getLoginHistory()
    {
        return $this->hasMany(SysHistoryUsers::class, ['user_id' => 'id'])
            ->andWhere(['user_table' => static::tableName()]);
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
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
//</editor-fold>
}
