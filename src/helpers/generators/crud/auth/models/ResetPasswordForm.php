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


use yii\base\InvalidConfigException;
use yii\base\Model;
use <?= $generator->modelClass ?>;

/**
 * Password reset form
 *
 * @package <?= $generator->authForms ?>
 * @version 0.1.0-971007
 * @since 1.0
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string new password set by the user
     */
    public $password;
    /**
     * @var string repeat new password set by the user
     */
    public $password_repeat;

    /**
     * @var <?= $modelClass ?> the found by using the given token
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array  $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidConfigException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidConfigException('توکن بازیابی گذرواژه نمی‌تواند خالی باشد.');
        }
        $this->_user = <?= $modelClass ?>::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidConfigException('توکن بازیابی گذرواژه درست نیست.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password'        => 'گذرواژه',
            'password_repeat' => 'تکرار گذرواژه',
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     * @throws \yii\base\Exception
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
