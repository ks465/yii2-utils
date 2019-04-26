#ActionColumn Class
Documentation Edition: 2.5-980206
Class Version: 2.4.1-980129

[[khans\utils\columns\ActionColumn|This class]] extends \kartik\grid\ActionColumn only to simplify routine, uniform development.
As it is seen in the example, there is no limit in numbers of **ActionColumn**s in a _GridView_.
By setting the visibility of standard action in one and adding _extraColumns_, there would be two distinctive columns.

```php
echo khans\utils\widgets\GridView::widget([
...
'columns' => [
    ...,
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'audit'          => true,
        'dropdown'       => true,
        
        'header'         => 'Pure Custom Actions',
        'visibleButtons' => [
            'view'     => false,
            'update'   => false,
            'delete'   => false,
            'download' => false,
            'audit'    => false,
        ],
        'extraItems'     => $extraColumns,
        'dropdownButton' => ['class' => 'btn btn-default alert-success', 'label' => 'GoOn'],
    ],
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'audit'          => false,
        'runAsAjax'      => true,
        'dropdown'       => true,
        'dropdownButton' => ['class' => 'btn btn-danger'],
    ],
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'runAsAjax'      => false,
        'audit'          => true,
        'dropdown'       => false,
        'download'       => Url::to(['/some-action', 'id' => 124]),
        'deleteAlert'=>'رکورد انتخاب شده از فهرست داده‌ها پاک خواهد شد.',
        'dropdownButton' => ['class' => 'btn btn-danger'],
    ],
],
...
```

+ _class_ It is of course mandatory and should always set to `khans\utils\columns\ActionColumn`.

+ _audit_ Adds an icon to each row that shows creator and updater data (time and person) in the tooltip. By clicking the icon, a modal grid shows the history of changes in the record.

+ _download_ is the URL to the download action. This is usually built using `yii\helpers\Url::to()` or similar.
It will directly fed into the `Html::a()`.

+ _runAsAjax_ In the new version of [[\khans\utils\widgets\GridView]] this is th key to run the grid view as AJAX.
The old `AjaxGridView` is dropped.
This value is available for the column and the unique actions (see below).

+ _dropdown_ shows the icons in the form of a dropdown menu. _**The two options dropdown and runAsAjax are not compatible with each other. Activate only one of them at a time.**_
+ _deleteAlert_ text used in the alert popup. defaults to `از پاک نمودن این {item} اطمینان دارید؟` 

###Extra Columns
This config adds one or more options to the `ActionColumn`.
Column without key and with empty body will be dropped.

```php
$extraColumns = [
    'name'   => [
        'icon'   => 'edit',
        'action' => 'my-action',
        'config' => ['class' => 'alert-danger'], // Use alert-* class with dropDown => true
    ],
    [],
    'rename' => [
        'title'  => 'Test Me',
        'icon'   => 'pencil',
        'config' => ['class' => 'text-success'], // Use text-* class with dropDown => false
    ],
    'reset'  => [
        'runAsAjax'=>false,
        'method' => 'get',
        'confirm' => [ //set to true to show a generic dialog
            'title' => 'آیا از فرستادن این گزینه اطمینان دارید؟',
            'message' => 'با انجام این عمل:' . '<ul>' .
                '<li>' .
                    'پرونده نامبرده بزای اقدام فرستاده خواهد شد.' .
                '</li>' .
                '<li>' .
                    'به جریان افتادن پرونده نامبرده از طریق ایمیل به وی اعلام خواهد شد.' .
                '</li>' .
                '</ul>' .
                'آیا اطمینان دارید؟'
        ],
    ],
];
```

_Array Key_ will be used in the template. If action is not present, it would serve as the action of the link
in `Url::to`.

_Array Values_
   + **title** In dropdown menu it is the title in the selection menu. In any case it will be used as the tooltip.
   + **icon** Type of glyphicon to use. Class glyphicon will be added automatically.
   It is optional and default is _link_.
   + **action** Name of action in the receiving controller. If it is omitted the action name will be the array key, and the default Url creator of the column is used. If it is set, the action target should be complete -- no assumption are done. 
   + **config** Configuration array which will directly fed into the `Html::a()` config part.
   + **runAsAjax** Whether the related action should run as AJAX request or full page reload.
   + **method** Select the action for the target as `POST` or `GET`. 
   + **confirm** If the action runs as AJAX and confirm is not empty of `false`, a confirming dialog is shown to the user to confirm the action. If the value is `true`, a generic message is used. Otherwise the following two elements should be present:
      - _title_ Text for title of the dialog.
      - _message_ Body of the confirm dialog.
   + **disabled** Accepts boolean or closure and shows the icon as disabled.
   + **disabledComment** is a string added to the title of the disabled action. Defaults to _Disabled_.
