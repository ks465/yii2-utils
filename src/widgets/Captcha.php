<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/3/16
 * Time: 8:08 AM
 */


namespace khans\utils\widgets;


use yii\base\InvalidConfigException;

/**
 * Show CAPTCHA with additional hint and unique look
 *
 * @package khans\utils\widgets
 * @version 2.2.1-980317
 * @since   1.0.0
 */
class Captcha extends \yii\base\Widget
{
    /**
     * @var \yii\base\Model the model behind the form
     */
    public $model;
    /**
     * @var \kartik\form\ActiveForm the user defined form
     */
    public $form;
    /**
     * @var string name of verifying node in the model
     */
    public $attribute = 'verifyCode';
    /**
     * @var integer to set as the tab index of the control. By define submit button has tab index 1000.
     */
    public $tabIndex = 999;
    /**
     * @var string|array the route of the action that generates the CAPTCHA images.
     */
    public $captchaAction = 'captcha';

    /**
     * Check for requirements
     *
     * @throws InvalidConfigException if the form is not a \kartik\form\ActiveForm or subclass,
     *    or the model is not a \yii\base\Model or subclass.
     */
    public function init()
    {
        if (!($this->form instanceof \kartik\form\ActiveForm)) {
            throw new InvalidConfigException('The form should be \kartik\form\ActiveForm');
        }

        parent::init();
    }

    /**
     * Render a form control consisting of CAPTCHA elements
     */
    public function run()
    {
        return $this->form->field($this->model, $this->attribute, [
            'options' => [
                'class' => 'clearfix form-group',
            ],
        ])
            ->widget(\yii\captcha\Captcha::class, [
                'captchaAction' => $this->captchaAction,
                'options'       => [
                    'tabindex'     => $this->tabIndex,
                    'autocomplete' => 'off',
                    'class'        => 'form-control ltr text-left',
                ],
            ])
            ->hint('<small>' . 'برای تغییر کد امنیتی می‌توانید روی آن کلیک کنید' . '</small>');
    }
}
