<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 25/09/18
 * Time: 12:16
 */


namespace khans\utils\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\User;

/**
 * User is the class for the `user` application component that manages the user authentication status.
 *
 * @property string              $fullName     نام کامل کاربر
 * @property string              $fullId       نام کامل کاربر و کد شناسایی
 * @property boolean             $isSuperAdmin یک مدیر سیستم است
 * @property UserTable|UserArray $identity
 *
 * @package khans\utils\models
 * @version 0.5-2-980314
 * @since   1.0
 */
class KHanUser extends User
{
    /**
     * @var string the class name of the identity [[\khans\utils\models\UserArray]] or [[\khans\utils\models\UserTable]] object.
     */
    public $identityClass = '\khans\utils\models\UserTable';
    /**
     * @var string name of table containing list of users for this application.
     */
    public $userTable = 'sys_users';

    /**
     * @var array List of user names that should be treated as super admins of the site
     */
    public $superAdmins = [];
    /**
     *
     * {@inheritdoc}
     */
    public $loginUrl = ['/khan/auth/login'];
    /**
     * {@inheritdoc}
     */
    public $accessChecker;

    /**
     *
     * {@inheritDoc}
     */
    public function init(){
        UserTable::setTableName($this->userTable);
        parent::init();
    }
    /**
     * Save last login time of the user in the identity table. By doing this a behavior
     *
     * @param UserArray|UserTable $identity the user identity information
     * @param bool                $cookieBased whether the login is cookie-based
     * @param int                 $duration number of seconds that the user can remain in logged-in status.
     * If 0, it means login till the user closes the browser or the session is manually destroyed.
     */
    protected function afterLogin($identity, $cookieBased, $duration): void
    {
        if($this->identity instanceof KHanModel){
            $b = $this->identity->detachBehavior('timestamp');
            $this->identity->last_visit_time = time();
            $this->identity->save();
            $this->identity->attachBehavior('timestamp', $b);
        }

        parent::afterLogin($identity, $cookieBased, $duration);
    }

    /**
     * Add extra fields sometimes required
     *
     * @return array
     */
    public function extraFields(): array
    {
        return ['fullId', 'fullName'];
    }

    /**
     * Get full name of persons from model data
     *
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->identity->fullName;
    }

    /**
     * Get full name of persons from model data along with id number in table
     *
     * @return string
     */
    public function getFullId(): string
    {
        return $this->identity->fullId;
    }

    /**
     * Returns a value indicating whether the user is an admin.
     *
     * @return bool whether the current user is an admin.
     */
    public function getIsSuperAdmin(): bool
    {
        if ($this->isGuest) {
            return false;
        }

        return $this->identity->getIsSuperAdmin();
    }

    /**
     *
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \yii\web\User::setIdentity()
     */
    public function setIdentity($identity)
    {
        parent::setIdentity($identity);
        if($identity instanceof \khans\utils\models\UserArray){
            $this->accessChecker = new \khans\utils\rbac\AccessCheckerArray();
        }elseif($identity instanceof \khans\utils\models\UserTable){
//             $this->accessChecker = new \khans\utils\rbac\AccessCheckerTable();
            if (empty($this->userTable)) {
                throw new InvalidConfigException('`userTable` is not defined in user component. This is required to select users\' table in the DB.');
            }
            UserTable::setTableName($this->userTable);
        }
    }
}
