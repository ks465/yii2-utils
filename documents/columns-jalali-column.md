#JalaliColumn Class
[[khans\utils\columns\JalaliColumn|This class]] extends [[DataColumn]] only to simplify routine, uniform development for dates column.
It can handle both `integer` timestamp columns, and also `string` date columns containing *year*, *month*, and *day* only. The delimiter in the string type can be on of `[.-/]` characters.
Vertical alignment is set to _middle_, and horizontal alignment is set to _center_.
The _width_ is fixed, and the cell value is calculated using [[components\Jalali]].
This is true for both the header and the content. 

_filterType_ is set to **khans\utils\widgets\DatePicker** so the filter element is consistent with other parts.

_attribute_ is required configurations for this widget to work properly.

```php
[
    'class'     => 'khans\utils\columns\JalaliColumn',
    'attribute' => 'created_at',
],
```

_JFormat_ is only optional configurations:

```php
[
    'class'     => 'khans\utils\columns\JalaliColumn',
    'attribute' => 'updated_at',
    'JFormat'   => Jalali::KHAN_SHORT,
],
```

##Search Model
In order to get a working filter, you need to change field type and query filters in the corresponding search model. Without this fixation, filtering does not work, and possibly shows errors.
