#ListUsersAction
Documentation Edition: 1.0-980215
Class Version: 1.0-980215


```php
'list-users'    => [
    'class' => '\khans\utils\actions\ListUsersAction',
],
```

```text
/some-controller/list-users?q=test
```

Or using the `Url` helper:
```php
'ajax' => [
    'url'      => Url::to(['list-users']),
    'dataType' => 'json',
    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
],
```