#RadioColumn Class
[[khans\utils\columns\RadioColumn|This class]] extends \kartik\grid\RadioColumn only to simplify routine, uniform development.
Vertical alignment is set to _middle_, and horizontal alignment is set to _center_.
This is true for both the header and the content. 

_name_ is fixed to **selection** so the bulk action button can find the selected button.

This column has nothing to configure. If any radio column is required for the model fields, use the parent one.

```php
[
    'class' => 'khans\utils\columns\RadioColumn',
],
```
