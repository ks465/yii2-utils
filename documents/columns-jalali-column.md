#JalaliColumn Class
Documentation Edition: 1.1-980218
Class Version: 0.1.8-980217

This column is used to 
It can handle both `integer` timestamp columns, and also `string` date columns containing *year*, *month*, and *day* only. The delimiter in the string type can be any non-digit single character.
Vertical alignment is set to _middle_, and horizontal alignment is set to _center_.
The _width_ is fixed, and the cell value is calculated using [components\Jalali](components-jalali.md). 

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

Search method of the search model:
```php
$this->created_at = Jalali::getTimestampFromString($this->created_at);

...
->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 86400])
...
```