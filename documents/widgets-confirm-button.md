#Confirm Button
Documentation Edition: 1.0-970929
Class Version: 1.1.0-970929

This widget is a submit button in essence, which shows a confirmation dialog before submitting the form. It extends the [\kartik\dialog\Dialog] directly, so all of the parent widget are usable.
It could submit form using both AJAX POST or normal POST. Remember that this widget should be placed in a form with POST method. The common parts of the setup are as follows:

+ `form.id` ID of the form is required for the widget to work. If it is omitted it would not show the modal dialog.
+ `form.action` Obviously it is standard attribute of the form
+ `form.method` Should be POST. Otherwise the widget won't show the modal dialog.
 
All of widget config elements are optional. They have defaults when required. 

+ `id` is used for setting up the javascript assets. It is really important when there is more than one ConfirmButton on a page. This is set to a unique string if ommited.
+ `type` is the dialog type from ConfirmButton::TYPE_* constants, which are equivalent to [\kartik\dialog\Dialog::TYPE_*] ones. Default is [ConfirmButton::TYPE_DANGER].
+ `formID` is the ID of the form to submit and this button is part of.
+ `buttonLabel` a text to show on the submit button in the form. Default is `بنویس`.
+ `buttonClass` complete set of classes of the submit button. Default is `btn btn-primary`. 
+ `buttonStyle` arbitrary CSS style for the submit button.
+  `title` a text for the header of the dialog. Default is empty string.
+ `message` a text for the body of the dialog. It can contain HTML tags and multiple lines.
+ `btnOKLabel` text to use as the OK button label for confirming the submission.
+ `btnCancelLabel` text to use as the Cancel button label for cancelling the submission.
+ `btnOKIcon` the glyphicon type to append to OK button class. `glyphicon glyphicon-` part is prepended to it. Default is `ok`.
+ `btnCancelIcon` the glyphicon type to append to Cancel button class. `glyphicon glyphicon-` part is prepended to it. Default is `ban-circle`.
+ `sendAjax` boolean switch to select the POST type. If it is `false` which is default, the form is submitted through normal POST method. If it is `true` the form will be submitted through AJAX POST method.
Current implementation shows the server response in an alert widget on success. In case of error, the received error message is shown in the alert widget. 

```php
$form = ActiveForm::begin([
    'id'     => 'form-a', //mandatory
    'action' => Url::to(['login']),
]);

echo ConfirmButton::widget([
    'id'          => 'js-id',
    'type'        => ConfirmButton::TYPE_INFO,
    'formID'      => $form->id,                 //mandatory
    'buttonLabel' => 'Load "login" Page with POST',
    'buttonClass' => 'btn btn-info',
    'buttonStyle' => 'color:red;',
    'title'       => 'Model dialog title',
    'message'     => Html::tag('h3', 'Any tailored message' . '<br/>' .
        'Which actually could be' .
        'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 
        'with HTML tags.',
    'btnOKLabel'     => 'Click this to go ahead',
    'btnCancelLabel' => 'Click this to cancel and go back',
    'btnOKIcon'      => 'fire',
    'btnCancelIcon'  => 'time',
    'sendAjax'       => true,
]);

ActiveForm::end();
```

###Normal POST
When `sendAjax` is not set or is set to `false`, the widget loads the target action of the form.

###AJAX POST
When `sendAjax` is set to `true`, the widget calls the target action through AJAX call.
After receiving response, if it is success, the received result is shown as an alert.
If it is error, the received error is shown as an alert.

Please note that it is the developer's responsibility to response appropriately in the target action.

By adding an empty element to the document and setting its ID as the `target` of the `.ajax` method, the result could be shown in the given element. _This is functionality is muted in the current javascript code_.
