#ArrayHelper Class
Documentation Edition: 1.2-971112
Class Version: 0.3.1-971027

This class contains more methods for transforming and reshaping arrays.
It extends \yii\helpers\ArrayHelper so there is only one class to import into namespace.


##Pivot
This static method is a transformer, which accepts an array and some row and column identifiers plus a numeric field.
In simple call the output is an array containing sum of all values of the numeric field --pivotValue.
Currently the only aggregating function available is `summation`.

This methods requires five arguments:
1. **$inputArray** is an array containing exactly two dimensions. Any simple array or `$query->asArray()->all()` could serve the purpose.

1. **$pivotColumn** is a single string or array of strings, which are names of fields in the input array.
The pivoted array would have columns with key equal to different combinations of these fields values.
Each key segment is separated by `.`.

1. **$pivotRow** is a single string or array of strings, which are names of fields in the input array. 
The pivoted array would have rows with key equal to different combinations of these fields values. 
Each key segment is separated by `.`.

1. **$pivotValue** is a single string which is the name of one of the fields, or it is a closure.
If it is a string, the output data cell (value of output_array[$pivotRow][$pivotColumn] element) contains the result of
the given aggregating function of input data. 
If it is a closure, the output data cell is simply output of the closure function. 

1. **$aggFunc (_optional_)** is type of aggregating function to use. Currently it is not used and _summation_ is used.

Calling the method with string `$pivotValue`

```php
$inputArray = [
['active_year' => '91', 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Female', 'students' => '503'],
['active_year' => '92', 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Female', 'students' => '552'],
['active_year' => '93', 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Female', 'students' => '589'],
['active_year' => '91', 'grade' => 'MSc', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => '201'],
['active_year' => '92', 'grade' => 'MSc', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => '200'],
['active_year' => '95', 'grade' => 'PhD', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => '54'],
['active_year' => '96', 'grade' => 'PhD', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => '44'],
];

ArrayHelper::pivot($inputArray, 'active_year', ['grade','gender'], 'students');

[
 'MSc.Female' => [ 'grade' => 'MSc', 'gender' => 'Female', '91_' => 503, '92_' => 552, '93_' => 589, ],
 'MSc.Male' => [ 'grade' => 'MSc', 'gender' => 'Male', '91_' => 201, '92_' => 200, ],
 'PhD.Male' => [ 'grade' => 'PhD', 'gender' => 'Male', '95_' => 54, '96_' => 44, ],
];
```

If called with a closure instead of a field name, the output is the result of the closure function without aggregation. 

```php
 ArrayHelper::pivot($inputArray, ['enter_type','gender'], 'grade', function($dataArray){ 
 return $dataArray['active_year'] . '/' . $dataArray['students'];
});

[
 'MSc' => ['grade' => 'MSc', 'Typical.Female' => '93/589', 'Pardis.Male' => '92/200',],
 'PhD' => ['grade' => 'PhD', 'Pardis.Male' => '96/44',],
];
```

##GroupBy
This static method is very similar to [Pivot](#pivot) method above. The only difference is that there is no pivoting columns
here. For the current version when using closure, the output array contains one addition column named `_data_`. 
This column contains the result of the closure function. If the `$pivotValue` is string, the same field contains the output value.
This methods requires four arguments:
1. **$inputArray** is an array containing exactly two dimensions. Any simple array or `$query->asArray()->all()` could serve the purpose.

1. **$pivotRow** is a single string or array of strings, which are names of fields in the input array. 
The pivoted array would have rows with key equal to different combinations of these fields values. 
Each key segment is separated by `.`.

1. **$pivotValue** is a single string which is the name of one of the fields, or it is a closure.
If it is a string, the output data cell (value of output_array[$pivotRow][$pivotValue] element) contains the result of
the given aggregating function of input data. 
If it is a closure, the output data cell (value of output_array[$pivotRow]['_data_'] element) is simply output of the closure function. 

1. **$aggFunc (_optional_)** is type of aggregating function to use. Currently it is not used and _summation_ is used.
 
 Calling the method with string `$pivotValue`
 
```php
ArrayHelper::groupBy($allData, ['grade','gender'], 'students');

[
 'MSc.Female' => ['active_year' => '91', 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Female', 'students' => 1644,],
 'MSc.Male' => ['active_year' => '91', 'grade' => 'MSc', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => 401,],
 'PhD.Male' => ['active_year' => '95', 'grade' => 'PhD', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => 98,],
];
```

If called with a closure instead of a field name, the output is the result of the closure function without aggregation. 

```php
ArrayHelper::groupBy($query->all(), 'short_name', function ($dataArray){
 return $dataArray['total'] / $dataArray['students'];
});

[
 'MSc.Female' => ['active_year' => 91, 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Female', 'students' => 503, '_data_' => '92/552',],
 'MSc.Male' => ['active_year' => 93, 'grade' => 'MSc', 'enter_type' => 'Typical', 'gender' => 'Male', 'students' => 589, '_data_' => '92/200',],
 'PhD.Male' => ['active_year' => 91, 'grade' => 'PhD', 'enter_type' => 'Pardis', 'gender' => 'Male', 'students' => 54, '_data_' => '93/44',],
 'PhD.Female' => ['active_year' => 93, 'grade' => 'PhD', 'enter_type' => 'Pardis', 'gender' => 'Female', 'students' => 44, '_data_' => '93/44',],
];
```

##appendTo
Appends the given string to each value in the array recursively.
##prependTo
Prepends the given string to each value in the array recursively.
##appendToKeys
Appends the given string to each key in the array recursively.
##prependToKeys
Prepends the given string to each key in the array recursively.
