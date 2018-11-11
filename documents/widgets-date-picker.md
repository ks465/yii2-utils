#DatePicker Widget
This class extends faravaghi\jalaliDatePicker\jalaliDatePicker. 
Idea of creating this widget is to simplify creating date picker widgets.
There is three attribute to set and the widget works:
+ **model**: _required_ data model,
+ **attribute**: _required_ name of attribute in the model,
+ **options**: _optional_ other settings as follows.

Example 1 - Use the widget directly:

```php
echo KHanS\Utils\widgets\DatePicker::widget([
    'attribute' => 'from_date',
    'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m', time())]),
    'options'   => [
        'minViewMode' => 'days',
        'startDate' => '1345/06/18',
        'endDate'   => '1388/01/01',
        'todayBtn'=>false,
    ],
]);
```

Example 2 - Use as a form field widget:

```php
echo $form->field($model, 'date_finish')->widget(KHanS\Utils\widgets\DatePicker::className(), [
    'options' => ['minViewMode' => 'months'],
]);
```

**Important: This widget only works with model+attribute set**.

This widget has only the following settings to setup:

+ **todayBtn**:
Boolean value to set showing a button link to today date at the bottom of the widget.
Default is _linked_.
   - _linked_ Selects today's date.
   - _view_ Shows today in the widget, and lets the user select.
   - _false_ Removes the button from view.
   
   
+ **minViewMode**: 
DatePicker widget shows three sections for gathering year, month, and day in sequence.
Default is _days_.
   - By setting this value to _years_ only the first section is shown to accept value for the year from the user.
   The value of the input would be a 4-digits integer. 
   - By setting it to _months_ the first and second sections are shown to accept values for year and month.
   The value of the input is in the form of _yyy/mm_.
   - Any other value or omitting it results in full date format _yyyy/mm/dd_ gathered in three
   successive sections.
   

+ **format**:
String to select how to show the value in the input element. Please note that the
initial value of the attribute, does not obey the format, and is shown as is.
If _minViewMode_ is set, the format will change according appropriately.
Default is _yyyy/mm/dd_.


+ **startDate**:
Sets the minimum available date for selection. Its format is _yyyy/mm/dd_.
Default is _-Infinity_.


+ **endDate**:
Sets the amximum available date for selection. Its format is _yyyy/mm/dd_.
Default is _+Infinity_.
