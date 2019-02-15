#DateRangePicker Widget
Documentation Edition: 1.0-970802
Class Version: 0.1.0-970802-dev

This class extends [[\faravaghi\jalaliDateRangePicker\jalaliDateRangePicker]].
This class presets many options and simplifies getting user input.
The main attributes to set are:

```php
echo DateRangePicker::widget([
    'id'        => 'attribute-one',
    'attribute' => 'from_date',
    'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
    'options'   => [
        'minDate' => '1395/01/01',
        'maxDate' => '1398/12/29',
    ],
]);
``` 

```php
echo $form->field($model, 'date_range')->widget(DateRangePicker::classname(), [
    'id'      => 'form-one',
    'options' => [
        'minDate' => '1395/01/01',
        'maxDate' => '1398/12/29',
    ],
]);
```
This widget has only the following settings to setup:


+ **id**:
This string is used as id option of the input without model and form. When model and form are used,
attribute name is the id.


+ **minDate**:
Sets the minimum available date for selection. Its format is _yyyy/mm/dd_.
Default is _-Infinity_.


+ **maxDate**:
Sets the amximum available date for selection. Its format is _yyyy/mm/dd_.
Default is _+Infinity_.

This widget can also accept time. But in this version it is not tuned.
