#BooleanColumn Class
Documentation Edition: 1.0-970904
Class Version: 0.1.0-970904

This is a wrapper for kartik BooleanColumn with some defaults:

_filterType_ is set to **kartik\select2\Select2** so the filter element is consistent with other parts.

_attribute_ is required configurations for this widget to work properly.

```php
[
    'class'            => 'khans\utils\columns\BooleanColumn',
    'attribute'        => 'status',
],
```

_trueLabel_, _falseLabel_, _trueIcon_, _falseIcon_ and _showNullAsFalse_ are optional configurations:

```php
[
    'class'           => 'khans\utils\columns\BooleanColumn',
    'attribute'       => 'status',
    'trueLabel'       => 'فعال',
    'falseLabel'      => 'غیرفعال',
    'trueIcon'        => GridView::ICON_ACTIVE,
    'falseIcon'       => GridView::ICON_INACTIVE,
    'showNullAsFalse' => true,
],
```
