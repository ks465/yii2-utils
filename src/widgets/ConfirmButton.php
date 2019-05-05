<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 2/16/16
 * Time: 11:07 PM
 */


namespace khans\utils\widgets;

use kartik\dialog\Dialog;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Create a modal confirm dialog for activating before form submission. It is meant to be used instead of submit button.
 * Use for confirming posting form actions -- like delete
 * Example:
 * ```php
 * $form = ActiveForm::begin([
 *      'id'     => 'any-form', //mandatory
 *      'action' => Url::to(['form-action']), //optional
 * ]);
 *  ... other form elements ...
 * echo \khans\utils\widgets\ConfirmButton::widget([
 *    'type'           => ConfirmButton::TYPE_INFO,
 *    'formID'         => 'any-form',
 *    'formAction'     => Url::to(['truncate', 'id' => $id]),
 *    'sendAjax'       => true,
 *    'buttonLabel'    => 'text to use as the form submitting button text',
 *    'buttonClass'    => 'btn btn-warning pull-left',
 *    'title'          => 'Modal dialog title',
 *    'message'        => Html::tag('h3', 'Any tailored message', ['style' => 'color: #d9534f']) . 'with HTML tags.',
 *    'btnOKLabel'     => 'Click this to go ahead',
 *    'btnCancelLabel' => 'Click this to cancel and go back',
 *    'btnOKIcon'      => 'fire',
 *    'btnCancelIcon'  => 'time',
 * ]);
 * ActiveForm::end();
 *```
 *
 * @package khans\utils\widgets
 * @version 1.2.0-980210
 * @since   1.0.0
 */
class ConfirmButton extends Dialog
{
    /**
     * @var string the identifying name of the public javascript id that will hold the settings for KrajeeDialog
     * javascript object instance.
     */
    public $id = null;
    /**
     * @var string type of dialog modal. One of Confirm::TYPE_* constants. Default is
     *     [[\khans\utils\widgets\ConfirmButton::TYPE_DANGER]].
     */
    public $type = ConfirmButton::TYPE_DANGER;
    /**
     * @var string ID of the containing form
     */
    public $formID = 'generic-form';
    /**
     * @var string label of the submit button
     */
    public $buttonLabel = 'بنویس';
    /**
     * @var string class for the main submit button in the form
     */
    public $buttonClass = 'btn btn-primary';
    /**
     * @var string CSS style of the submit button
     */
    public $buttonStyle = '';
    /**
     * @var string title of the modal dialog
     */
    public $title = '';
    /**
     * @var string body text of the modal dialog
     */
    public $message = '';
    /**
     * @var string label of the OK button in the modal dialog
     */
    public $btnOKLabel = 'آری';
    /**
     * @var string label of the Cancel button in the modal dialog
     */
    public $btnCancelLabel = 'خیر';
    /**
     * @var string glyphicon icon name  of the OK button in the modal dialog. Default is "ok".
     */
    public $btnOKIcon = 'ok';
    /**
     * @var string glyphicon icon name  of the Cancel button in the modal dialog. Default is "ban-circle".
     */
    public $btnCancelIcon = 'ban-circle';
    /**
     * @var bool send the form using AJAX Post or normal POST. Default is false, using normal POST.
     */
    public $sendAjax = false;
    /**
     * @var string javascript code for showing the modal dialog
     */
    private $js = '';

    /**
     * @var string Target action for the button. If left blank, action of the form --whatever it is-- will be used.
     */
    public $formAction = null;

    /**
     * Set the required setup configurations.
     *
     * @throws InvalidConfigException if the [[\khans\utils\widgets\ConfirmButton\formId]] is not set in the
     *     configuration.
     */
    public function init()
    {
        if (is_null($this->formID)) {
            throw new InvalidConfigException('Setting widget ID equal to the ID of the containing form is mandatory.');
        }

        if (is_null($this->id)) {
            $this->id = 'KHan_btn_' . str_replace('.', '_', microtime(true));
        }

        // multi-line messages would distort without this
        $this->message = str_replace("\n", "\\\n", $this->message);

        if ($this->sendAjax) {
//            echo '<div id="result"></div>';
            $this->js = <<< JS
$('#$this->formID').on("beforeSubmit", function() {
    $this->id.confirm('$this->message',
        function (result) {
            if (result) {
                var form = $('#$this->formID');
                var url = form.attr('action');
                $.ajax({
                    // target: "#result",
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        $this->id.alert(data);
                        // $("#result").html(data);
                    },
                    error: function (data, x, result) {
                        $this->id.alert(result);
                        // $("#result").html(result);
                    }
                });
            }
        }
    );
    return false;
});
JS;
        } else {
            $this->js = <<< JS
$('#$this->formID').on("beforeSubmit", function() {
    $this->id.confirm('$this->message',
        function (result) {
            if (result) {
               $('#$this->formID').unbind("beforeSubmit").submit();
            }
        }
    );
    return false;
});
JS;
        }

        parent::init();
    }

    /**
     * Set the modal dialog in the document and show the submit button
     *
     * @throws \Exception
     */
    public function run()
    {
        echo Dialog::widget([
            'libName' => $this->id,
            'options' => [
                'type'           => $this->type,
                'title'          => $this->title,
                'btnOKClass'     => 'pull-left btn ' . str_replace('type', 'btn', $this->type),
                'btnOKLabel'     => '<i class="glyphicon glyphicon-' . $this->btnOKIcon . '"></i> ' .
                    $this->btnOKLabel,
                'btnCancelLabel' => '<i class="glyphicon glyphicon-' . $this->btnCancelIcon . '"></i> ' .
                    $this->btnCancelLabel,
            ],
        ]);

        $this->getView()->registerJs($this->js);

        echo Html::submitButton($this->buttonLabel, [
            'formaction' => $this->formAction,
            'id'         => 'btn-confirm',
            'class'      => $this->buttonClass,
            'style'      => $this->buttonStyle,
            'name'       => 'confirm-button',
        ]);
    }
}
