#KHanWebController
Documentation Edition: 1.0-971013
Class Version: 0.2.3-980215


This base class forces the delete action to be only done by POST.
And a place holder for `actionParentsList()` for children controllers for filtering the
grid.

```php
public function behaviors()
{
    return [
        'verbs' => [
            'class'   => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
    ];
}
```

The following actions are also available:
```php
public function actions()
{
    return [
        'error'   => [
            'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
            'class'           => 'yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
        'help'    => [
            'class' => '\khans\utils\actions\help\HelpAction',
        ],
        'table-schema'    => [
            'class' => '\khans\utils\actions\ListTablesAction',
        ],
        'list-users'    => [
            'class' => '\khans\utils\actions\ListUsersAction',
        ],
    ];
}
```