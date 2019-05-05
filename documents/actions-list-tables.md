#ListTablesAction
Documentation Edition: 1.0-980215
Class Version: 1.0-980215

List all the tables in the given database connection

```php
'table-schema'    => [
    'class' => '\khans\utils\actions\ListTablesAction',
],
```
```text
.../somecontroller/list-tables?q=tab&db=test
```

Or using the `Url` helper:
```php
'ajax' => [
    'url'      => Url::to(['table-schema', 'db' => 'test']),
    'dataType' => 'json',
    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
],
```