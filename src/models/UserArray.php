<?php
namespace khans\utils\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use khans\utils\components\Jalali;

/**
 * Class UserArray holds required parts for Yii::$app->user->identity in the form of hard-coded list of users.
 *
 * Use following to generate the #1 user
 *
 * ```php
 * $user = khans\utils\models\UserArray::createNewUser([
 * 'id' => '1',
 * 'username' => 'keyhan',
 * 'email' => 'admin@khan.org',
 * 'fullName' => 'مدیر سیستم',
 * 'password' => '123456',
 * 'accessToken' => true
 * ]
 * ```
 *
 * @package khans\utils\models
 * @version 0.2.1-980308
 * @since 1.0
 */
class UserArray extends \yii\base\BaseObject implements IdentityInterface
{

    /**
     *
     * @var string name of table holding the user data
     */
    private static $_tableName = '_array_';

    /**
     *
     * @var string classname of the table for logging failed or successful login attempts
     */
    public static $_loginHistoryFile = '@runtime/log/user-login.log';

    /**
     * User ID
     *
     * @var integer
     */
    public $id;

    /**
     * User login name
     *
     * @var string
     */
    public $username;

    /**
     * User name and family
     *
     * @var string
     */
    public $fullName;

    /**
     * User email
     *
     * @var string
     */
    public $email;

    /**
     * User hashed password
     *
     * @var string
     */
    public $password;

    /**
     * Authentication key specific to the individual user
     *
     * @var string
     */
    public $authKey;

    /**
     * Access token specific to the individual user
     *
     * @var string
     */
    public $accessToken;

    /**
     * List of users known to the application
     *
     * @var array
     */
    private static $users = [
        '0' => [
            'id' => '0',
            'username' => 'system',
            'email' => 'noreply@khan.org',
            'fullName' => 'سامانه خودکار',
            'password' => '!',
            'authKey' => null,
            'accessToken' => 'ZI9dhEqteCqSrL35Y6nwwvHOtcMJIbeDBFt1eZFWopjNcGxtxsqJHk7YT53-HVUu5IZeEkyjeZb5JeIizjO_CCqm0HlfMtaHvJV8kV3Cm9g69ejS6VnY3S_HTFSWiXzS'
        ],
        '1' => [
            'id' => '1',
            'username' => 'keyhan',
            'email' => 'admin@khan.org',
            'fullName' => 'مدیر سیستم',
            'password' => '$2y$13$dtXB4NoNA4EoxGs1z3vPReR2OO8x1RIOA8idShs6D3vPPn8f3iS3W',
            'authKey' => '8T7yYwsOdZVB__L5-RLZuygJ39y0_ltV',
            'accessToken' => 'Sj2jhRfzu3KBSwMaGH4C3lU84Q0hKs9qORL05nit0pt-TnTp8XzYdAEOtbolskVniMLU58gyDDytBkRlfVPGL0ng5wnZVit6No4B1NlMlCLSR-LIn89BUCFjc3lRVuca'
        ]
    ];

    /**
     * Mimic findOne method of actrive record
     *
     * @param integer $id
     *            user id
     * @return KHanIdentity|null
     */
    public function findOne($id)
    {
        if ($id == 0) {
            return null;
        }
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * Find user by ID number
     *
     * @param integer $id
     *            user ID number
     * @return KHanIdentity|null
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Find user by the access token
     *
     * @param string $token
     *            Access token
     * @param mixed $type
     *            the type of the token
     * @return KHanIdentity|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if (empty($user['accessToken'])) {
                continue;
            }
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username or email
     *
     * @param string $username
     * @return KHanIdentity|null
     */
    public static function findByUsername($username)
    {
        if (strtolower($username) == 'system') {
            return null;
        }
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
            if (strcasecmp($user['email'], $username) === 0) {
                if (strtolower($user['username']) == 'system') {
                    return null;
                }
                return new static($user);
            }
        }

        return null;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get full name of persons from model data
     *
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
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
     * Returns a value indicating whether the user is an admin.
     * Supposedly this type of user identity manager does not allow non-admin users.
     * So all the users are assumed admins.
     *
     * @return bool whether the current user is an admin.
     */
    public function getIsSuperAdmin(): bool
    {
        return $this->id > 0;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        if (empty($this->authKey) || empty($authKey)) {
            return false;
        }
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     * and if the authKey is not set returns false
     *
     * @param string $password
     *            password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        try {
            return Yii::$app->security->validatePassword($password, $this->password);
        } catch (yii\base\InvalidArgumentException $e) {
            return FALSE;
        }
    }

    /**
     * Write data about a successful login attempt from valid user
     *
     * @param string $username
     *            string used as username or email for login
     * @param integer $attempts
     *            number of attempts to login
     *
     * @return bool result of saving the log
     */
    public static function logSuccessLogin($username, $attempts): bool
    {
        return self::saveLogin($username, Yii::$app->user->id, 'LOGIN_SUCCESSFUL', $attempts);
    }

    /**
     * Write data about a failed login attempt from any user --either known or unknown.
     *
     * @param string $username
     *            string used as username or email for login
     * @param integer $attempts
     *            number of attempts to login
     *
     * @return bool result of saving the log
     */
    public static function logFailedLogin($username, $attempts): bool
    {
        return self::saveLogin($username, 'X', 'LOGIN_FAILED', $attempts);
    }

    /**
     * Write data about a login event built by other methods
     *
     * @param string $username
     *            string used as username or email for login
     * @param string $userID
     *            user ID for the logged in user set by the other methods
     * @param string $result
     *            result of login method of the [[KHanUser]] class
     * @param integer $attempts
     *            number of attempts to login
     *
     * @see logSuccessLogin
     * @see logFailedLogin
     *
     * @return bool result of saving the log
     */
    private static function saveLogin($username, $userID, $result, $attempts): bool
    {
        $filename = \Yii::getAlias(static::$_loginHistoryFile);
        if (! file_exists($filename)) {
            $dirname = dirname($filename);
            if (! is_dir($dirname)) {
                mkdir($dirname, 0777, true);
            }
            file_put_contents($filename, implode(',', [
                'username',
                'user_id',
                'timestamp',
                'date',
                'time',
                'user_table',
                'result',
                'attempts',
                'ip'
            ]) . "\n");
        }
        if (! is_writable($filename)) {
            throw new Exception('User log file ' . $filename . ' is not writable.');
        }

        $h = fopen($filename, 'a');
        $time = time();

        $logger = [
            'username' => $username,
            'user_id' => (string) $userID,
            'timestamp' => $time,
            'date' => Jalali::date('Y/m/d', $time),
            'time' => Jalali::date('H:i:s', $time),
            'user_table' => static::$_tableName,
            'result' => $result,
            'attempts' => $attempts,
            'ip' => Yii::$app->request->getUserIP()
        ];

        if (fwrite($h, implode(',', $logger) . "\n") > 0) {
            return fclose($h);
        }
    }

    /**
     * Get list of recorded login attempts for the user
     */
    public function getLoginHistory()
    {
        $filename = \Yii::getAlias(static::$_loginHistoryFile);
        if (! is_readable($filename)) {
            throw new Exception('User log file ' . $filename . ' is not readable.');
        }
        return file_get_contents(\Yii::getAlias(static::$_loginHistoryFile));
    }

    /**
     * A simple utility function to create a new user array.
     * You should add the resultant output to the [$users] manually.
     *
     * @param array $config
     *            Array containing ('id', 'userName', 'eMail', 'fullName', 'password', 'accessToken') as array keys
     * @return array
     */
    public static function createNewUser($config)
    {
        $user = [
            $config['id'] => [
                'id' => $config['id'],
                'username' => $config['userName'],
                'email' => $config['eMail'],
                'fullName' => $config['fullName'],
                'password' => Yii::$app->security->generatePasswordHash($config['password']),
                'authKey' => Yii::$app->security->generateRandomString(),
                'accessToken' => $config['accessToken'] ? Yii::$app->security->generateRandomString(128) : null
            ]
        ];

        return $user;
    }
}
