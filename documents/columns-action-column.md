#ActionColumn Class
[[KHanS\Utils\columns\ActionColumn|This class]] extends \kartik\grid\ActionColumn only to simplify routine, uniform development.
As it is seen in the example, there is no limit in numbers of **ActionColumn**s in a _GridView_.
By setting the visibility of standard action in one and adding _extraColumns_, there would be two distinctive columns.

```php
echo KHanS\Utils\widgets\GridView::widget([
...
    'columns' => [
        ...,
        [
            'class'          => 'KHanS\Utils\columns\ActionColumn',
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
            'class'          => 'KHanS\Utils\columns\ActionColumn',
            'audit'          => false,
            'runAsAjax'      => true,
            'dropdown'       => true,
            'dropdownButton' => ['class' => 'btn btn-danger'],
        ],
        [
            'class'          => 'KHanS\Utils\columns\ActionColumn',
            'runAsAjax'      => false,
            'audit'          => true,
            'dropdown'       => false,
            'download'       => Url::to(['/some-action', 'id' => 124]),
            'deleteAlert'=>'رکورد انتخاب شده از فهرست داده‌ها پاک خواهد شد.',
            'dropdownButton' => ['class' => 'btn btn-danger'],
        ],
    ],
    ...
]);
```

+ _class_ It is of course mandatory and should always set to _**'KHanS\Utils\columns\ActionColumn'**_.
+ _audit_ Adds an icon to each row that shows _created_by_, _created_at_, _created_by_, and _updated_by_ of each reord.
+ _download_ is the URL to the download action. This is usually built using `yii\helpers\Url::to()` or similar.
It will directly fed into the `Html::a()`.
+ _runAsAjax_ In the new version of [[\KHanS\Utils\widgets\GridView]] this is th key to run the grid view as AJAX.
The old `AjaxGridView` is dropped.
This value is available for the column and the unique actions (see below).
+ _deleteAlert_ text used in the alert popup. defaults to `از پاک نمودن این {item} اطمینان دارید؟` 

###Extra Columns
This config adds one or more options to the `ActionColumn`.
Column without key and with empty body will be dropped.

```php
$extraColumns = [
    'name'   => [
        'icon'   => 'edit',
        'action' => 'my-action',
        'config' => ['class' => 'alert-danger'], // Use alert-* class with dropDown => dropDown => true
    ],
    [],
    'rename' => [
        'title'  => 'Test Me',
        'icon'   => 'pencil',
        'config' => ['class' => 'text-success'], // Use text-* class with dropDown => false
    ],
    'reset'  => [
        'runAsAjax'=>false,
    ],
];
```

_Array Key_ will be used in the template. If action is not present, it would serve as the action of the link
in `Url::to`.

_Array Values_
   + **title** In dropdown menu it is the title in the selection menu. In any case it will be used as the tooltip.
   + **icon** Type of glyphicon to use. Class glyphicon will be added automatically.
   It is optional and default is _link_.
   + **action** Name of action in the receiving controller. It is optional and default is array key of the item.
   + **config** Configuration array which will directly fed into the `Html::a()` config part.
   + **runAsAjax** Whether the related action shoud run as AJAX request or full page reload. 
