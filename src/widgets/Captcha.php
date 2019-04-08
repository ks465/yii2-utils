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
 * @version 2.1.1-971112
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
     * @var string the template for arranging the CAPTCHA image tag and the text input tag.
     */
    private $template = '<div class="row" style="vertical-align: middle !important;float: none;">
    <div class="col-md-offset-1 col-md-3">{image}</div>
    <div class="col-md-4 ltr text-left">{input}</div>
    <div class="col-md-4 text-justify small"><i class="glyphicon glyphicon-info-sign"></i> برای تغییر کد امنیتی می‌توانید روی آن کلیک کنید</div>
    </div>';

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
                'template' => $this->template,
                'options'  => [
                    'tabindex' => $this->tabIndex,
                    'class'    => 'form-control',
                ],
            ])
            ->label(false);
    }
}
