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
use yii\base\Model;
use <?= $generator->modelClass ?>;
use yii\helpers\Url;

/**
 * Password reset request form
 *
 * @package <?= $generator->authForms ?>
 *
 * @version 0.1.0-971007
 * @since 1.0
 */
class PasswordResetRequestForm extends Model
{
    /**
     * @var string email address of the calling user
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '<?= $generator->modelClass ?>',
                'filter' => ['status' => <?= $modelClass ?>::STATUS_ACTIVE],
                'message' => 'کاربری با این ایمیل شناخته نشد.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'نشانی ایمیل',
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     * @throws \yii\base\Exception
     */
    public function sendEmail()
    {
        /* @var <?= $modelClass ?> */
        $user = <?= $modelClass ?>::findOne([
            'status' => <?= $modelClass ?>::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!<?= $modelClass ?>::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            return false;
        }

        $resetLink = Url::to(['reset-password', 'token' => $user->password_reset_token], true);

        return Yii::$app
            ->mailer
            ->compose(
                //['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTextBody($resetLink)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
