#Captcha Class
Documentation Edition: 1.1-971112
Class Version: 2.1.1-971112
As most CAPTCHA users forget how to change the image, this widget adds a hint to it.
In addition to that the look is also changed to a more condensed form.

This widget requires the `form` and `model` attributes/

```php
echo \khans\utils\widgets\Captcha::widget([
    'model' => $model,
    'form' => $form,
    'attribute' => 'verifyCode', // this is the default
])
```

This would render a form field widget.
The form should be  a [\kartik\form\ActiveForm] or subclass,
The model should be a [\khans\utils\models\KHanModel] or subclass.
