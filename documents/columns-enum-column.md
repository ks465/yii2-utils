#EnumColumn Class
[[khans\utils\columns\EnumColumn|This class]] extends \kartik\grid\EnumColumn only to simplify routine, uniform development.
Vertical alignment is set to _middle_, and horizontal alignment is set to _center_.
This is true for both the header and the content. 

_filterType_ is set to **kartik\select2\Select2** so the filter element is consistent with other parts.

_attribute_ and _enum_ are required configurations for this widget to work properly.

```php
[
    'class'            => 'khans\utils\columns\EnumColumn',
    'attribute'        => 'status',
    'enum'             => KHanModle::getStatuses(),
],
```
