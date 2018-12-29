<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 13/12/18
 * Time: 17:29
 */

use khans\utils\components\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>
namespace <?= $generator->authForms ?>;


use Yii;
use khans\utils\models\KHanIdentity;
use <?= $generator->modelClass ?>;


/**
 * LoginForm is the model behind the login form.
 *
 * @package <?= $generator->authForms ?>

 * @version 0.1.0-970928
 * @since 1.0
 */
class LoginForm extends yii\base\Model
{
    /**
     * @var string username or email of the user
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var bool
     */
    public $rememberMe = true;
    /**
     * @var string CAPTCHA
     */
    public $verifyCode;
    /**
     * @var KHanIdentity
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
            ['verifyCode', 'captcha', 'on' => 'withCaptcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'شناسه کاربر',
            'password' => 'گذرواژه',
            'rememberMe' => 'به یاد بسپار',
            'verifyCode' => 'کد امنیتی',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'شناسه کاربری یا گذرواژه درست نیست.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $this->getUser();
            $result = Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            //if ($result) {
            //}
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return KHanIdentity|null
     */
    private function getUser()
    {
        if ($this->_user === false) {
            $this->_user = <?= $modelClass ?>::findByUsername($this->username);
        }
        return $this->_user;
    }
}
