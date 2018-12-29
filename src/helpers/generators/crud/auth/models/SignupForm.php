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
use khans\utils\components\StringHelper;
use khans\utils\models\KHanIdentity;
use <?= $generator->modelClass ?>;

/**
 * Class SignupForm offers validating and saving new users
 *
 * @package <?= $generator->authForms ?>

 * @version 0.1.0-970923
 * @since 1.0
 */
class SignupForm extends \yii\base\Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $name;
    public $family;
    public $verifyCode;
    public $consent;


    /**
     * Return validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'family', 'email', 'password', 'password_repeat', 'verifyCode'], 'required'],
            [['email', 'family', 'name'], 'filter', 'filter' => 'trim'],
            [['name', 'family', 'email'], 'string', 'length' => [3, 63]],
            ['email', 'email'],
            [['password', 'password_repeat'], 'string', 'length' => [6, 63]],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [
                'email',
                'unique',
                'targetClass' => '<?= $generator->modelClass ?>',
               'targetAttribute' => ['email'],
                'message' => 'این نشانی ایمیل پیش از این گرفته شده است.',
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
//            ['consent', 'required'],
            ['consent', 'boolean'],
            [
                'consent',
                'compare',
                'compareValue' => true,
                'message'      => 'پیش از ثبت نام می‌بایست آیین‌نامه‌های مربوط را بخوانید و بپذیرید.',
            ],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * Return labels of the fields in the form
     */
    public function attributeLabels()
    {
        return [
            'name'            => 'نام',
            'family'          => 'نام خانوادگی',
            'email'           => 'ایمیل',
            'password'        => 'گذرواژه',
            'password_repeat' => 'تکرار گذرواژه',
            'verifyCode'      => 'کد امنیتی',
            'consent'         => 'کلیه ضوابط و شرايط دانشگاه را مطالعه نموده‌ام و می‌پذیرم.',
        ];
    }


    /**
     * Signs user up.
     *
     * @return KHanIdentity|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new <?= $modelClass ?>();
        $user->setScenario('profile');
        $user->name = $this->name;
        $user->family = $this->family;
        $user->username = $this->name . '.' . $this->family;
        $user->email = $this->email;
        $user->generateAuthKey();
        $user->setPassword($this->password);

        $user->validate();
        if ($user->hasErrors()) {
            Yii::$app->session->addFlash('error', $user->getModelErrors());

            return null;
        }
        $user->save(false);

        return $user;
    }
}
