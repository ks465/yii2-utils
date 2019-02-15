<?php
/**
 * This is the template for generating a User Authentication controller class file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-971111
 * @since   1.0
 */

use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;


/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);

$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>


namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use <?= $generator->authForms ?>\LoginForm;
use <?= $generator->authForms ?>\SignupForm;
use <?= $generator->authForms ?>\PasswordResetRequestForm;
use <?= $generator->authForms ?>\ResetPasswordForm;
use khans\utils\models\KHanIdentity;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

/**
 * <?= $controllerClass ?> implements the authentication actions for <?= $modelClass ?> model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-971111
 * @since   1.0
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * Session key to hold the number of failed login attempts of the given user
     */
    private $loginAttemptsVar = '__LoginAttemptsCount';
    /**
     * Number of failed login attempts of the given user
     */
    private $attemptsBeforeCaptcha = 3;

    /**
     * Set default access filters for main actions
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['login', 'logout', 'signup', 'password-reset-request', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'password-reset-request', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Set default common actions
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Log a <?= $modelClass ?> User model. If login attempts failed show CAPTCHA
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();

        //make the captcha required if the unsuccessful attempts are more of thee
        if ($this->getLoginAttempts() >= $this->attemptsBeforeCaptcha) {
            $model->scenario = 'withCaptcha';
        }

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) and $model->login()) {
                KHanIdentity::logSuccessLogin($model['username'], $this->getLoginAttempts());
                $this->setLoginAttempts(0); //if login is successful, reset the attempts

                return $this->goBack();
            }
            //if login is not successful, increase the attempts
            $this->setLoginAttempts($this->getLoginAttempts() + 1);
            KHanIdentity::logFailedLogin($model['username'], $this->getLoginAttempts());
        }

        return $this->render('login', [
            'model' => $model,
            'withEmail' => true,
        ]);
    }

    /**
     * Log the current user out and close the session
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->destroy();

        return $this->goHome();
    }

    /**
     * Sign up a new user for the site
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Request for a password reset token and link
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionPasswordResetRequest()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success',
                    'لینکی برای دسترسی به صفحه تعریف گذرواژه برای شما ارسال شد.' . '<br/>' .
                    'برای ادامه مراحل ایمیل خود را بازبینی نمایید.'
                );

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'متاسفانه بازیابی گذرواژه برای ایمیل داده شده امکان ندارد.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Reset a password using previously generated token
     *
     * @param string $token the predefined token unique to the user with limited validity lifetime
     *
     * @return mixed
     *
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
    */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidConfigException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'گذرواژه به روزرسانی شد.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Get number of times a visitor has failed to login
     *
     * @return integer
     */
    protected function getLoginAttempts()
    {
        return Yii::$app->getSession()->get($this->loginAttemptsVar, 0);
    }

    /**
     * Save number of failed login attempts from session
     *
     * @param $value number of failed login trials before CAPTCHA shows up
     *
     * @return void
     */
    protected function setLoginAttempts($value)
    {
        Yii::$app->getSession()->set($this->loginAttemptsVar, $value);
    }
}
