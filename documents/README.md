#Guide
This is document for KHanS/yii2-utils package.

Documentation Edition: 1.0-970803

#Documentation
Guides, notes, and anything regarding good style programming and documenting:

 1. [Document Tips and Tricks](documents.md)
 
 
#Components
All the classes in the component directory of the package:

1. [Array Helper](components-array-helper.md) contains more methods for transforming and reshaping arrays.
1. [Jalali & JalaliX](components-jalali.md) contain Jalali date object creation and manipulation. 

#Columns
Columns are classes extending \kartik\grid\ActionColumn instead of \yii\grid\ActionColumn.
They are specialized versions for Kartik Gridview.

1. [ActionColumn](columns-action-column.md)

#Models

1. [Base Model](models-khan-model.md) contains basic skeleton for all models.
1. [Base user](models-khan-user.md) contains basic skeleton for all user models.


#Others
These are miscellaneous classes for configuring the package or installation.

1. [Settings](settings.md) contains all the settings and constant values.
1. [Migrations](helpers-migrations.md) contains all the migrations required for rising the package up and running.
 
 
#StartUp
General requirements in application options:

```php
    'language' => 'fa-IR',
    'timeZone' => 'Asia/Tehran',
     'aliases'    => [
        '@khan' => '@vendor/khans465/yii2-utils',
     ],
     'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '_NULL_value_to_display_',
            'booleanFormat' => ['_FALSE_', '_TRUE_'],
            'locale' => 'fa_IR@calendar=persian',
            'decimalSeparator' => '-',
            'thousandSeparator' => '_',
            'numberFormatterOptions' => [ //These two require PHP intl extension
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ]
        ],
        ...
     ],
```

Add following code to console options in order to setup migrations table:

```php
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationTable' => 'sys_migration',
    ],
],
```
###Sanitizing User Input
Add following code to application options in order to filter or otherwise sanitize every user input: 

```php
'on beforeRequest' => [
    '\KHanS\Utils\components\StringHelper',
    'screenInput',
],
```
###RBAC Setup
Add following code to `component` section of application options in order to setup AuthManager tables:
 
```php
'user' => [
    'class' => '\KHanS\Utils\models\KHanUser',
    'identityClass'   => '\KHanS\Utils\models\KHanIdentity',
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => '_identity_name_',
        'httpOnly' => true,
        'path' => '_path_to_application_',
    ],
],
'authManager' => [
    'class' => 'yii\rbac\DbManager',
    'ruleTable' => 'sys_auth_rule',
    'itemTable' => 'sys_auth_item',
    'itemChildTable' => 'sys_auth_item_child',
    'assignmentTable' => 'sys_auth_assignment',
],
```

Run ./yii migrate/up --migrationPath=@yii/rbac to build required tables with the given names.
