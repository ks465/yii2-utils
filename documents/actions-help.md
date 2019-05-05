#HelpAction
Documentation Edition: 1.0-980208
Class Version: 2.1.-980208

The base controller [KHanWebController](controllers-khan-web.md) has the help method set. 
If your controller extends this, then the only thing you need to do is adding the following parts to main layout of the site:

Define a link/button to activate help (it can be in the top menu):
```html
<a class="btn btn-info" onclick="<?= $onClick ?>" href="#">Help</a>
```

Define Javascript responder to click event of the `Help` button:
```php
$onClick = "
$('#modalHelp').modal('show');
$.ajax({
    type: 'POST',
    cache: false,
    url: '" . Url::to(['help',
            'module' => $this->context->module->id,
            'controller' => $this->context->id,
            'action' => $this->context->action->id,
        ]) . "',
    success: function(response) {
        $('#modalHelp .modal-body').html(response);
    },
});
return false;
";
```

Add a modal element dedicated to help action:
```php
Modal::begin([
    'size'        => Modal::SIZE_LARGE,
    'closeButton' => ['label' => 'ببند', 'class' => 'btn btn-success pull-left'],
    'id'          => 'modalHelp',
    'header'      => '<h4><small>راهنما:</small> <mark>' . $this->title . '</mark></h4>',
    'footer'      => '<p>&nbsp;' .
        '<span class="pull-left">' . Yii::getVersion() . '</span>' .
        '</p>',
]);
Modal::end();
```
Done! The las step is define the individual help pages.


If `YII_ENV` equals "dev" referring page and requested file are shown:
```text
Request Data:

Referrer Page: demos/default/index
Help Page: modules/demos/views/helps/default-index
Help File: /var/www/html/khans/modules/demos/views/helps/default-index.md
```

By using these data, the help file for each action --page-- can be easily determined.
