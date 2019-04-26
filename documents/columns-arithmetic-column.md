#ArithmeticColumn Class
Documentation Edition: 1.0-980128
Class Version: 0.1.0-980128

Only `filterInputOptions` is changed to remind the user to use any of `<`, `>`, `<=`, or `>=` operators in the filter of the column.
All other settings are inherited from DataColumn.

```php
[
    'class'            => 'khans\utils\columns\ArithmeticColumn',
    'attribute'        => 'Numeric_data',
],
```

Required changes in the `searchModel`:

+ Data type of the attribute should be set to `string` or `safe` in the `rules()` method to avoid validation errors.
+ In order to use the given operators in filtering data, remember to use this in the `searchModel`:

```php
$this->query->andFilterCompare('real_column', $this->real_column);
```
