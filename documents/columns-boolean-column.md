#BooleanColumn Class
[[KHanS\Utils\columns\BooleanColumn|This class]] extends \kartik\grid\BooleanColumn only to simplify routine, uniform development.
Vertical alignment is set to _middle_, and horizontal alignment is set to _center_.
This is true for both the header and the content. 

_filterType_ is set to **kartik\select2\Select2** so the filter element is consistent with other parts.

_attribute_ is required configurations for this widget to work properly.

```php
[
    'class'            => 'KHanS\Utils\columns\BooleanColumn',
    'attribute'        => 'status',
],
```

_trueLabel_, _falseLabel_, _trueIcon_, _falseIcon_ and _showNullAsFalse_ are optional configurations:

```php
[
    'class'           => 'KHanS\Utils\columns\BooleanColumn',
    'attribute'       => 'status',
    'trueLabel'       => 'Yes',
    'falseLabel'      => 'No',
    'trueIcon'        => GridView::ICON_ACTIVE,
    'falseIcon'       => GridView::ICON_INACTIVE,
    'showNullAsFalse' => true,
],
```
