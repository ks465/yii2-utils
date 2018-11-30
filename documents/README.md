#Guide
This is document for KHanS/yii2-utils package.

Documentation Edition: 1.0-970803

#Documentation
Guides, notes, and anything regarding good style programming and documenting:

 1. [Document Tips and Tricks](documents.md)
 2. [Setup for Persian](persian.md)
 
#Actions
1. [CSV Grid View](actions-csv-grid-view.md) shows data saved in a CSV file as a [[\khans\utils\widgets\GridView]]. 

#Components
All the classes in the component directory of the package:

1. [Array Helper](components-array-helper.md) contains more methods for transforming and reshaping arrays.
1. [File Helper](components-file-helper.md) contains methods to read and write data in different formats.
1. [Jalali and JalaliX](components-jalali.md) contain Jalali date object creation and manipulation.
1. [Math Helper](components-math-helper.md) contains methods to do some mathematical routines easier. 
1. [SQL Formatter](components-sql-formatter.md) --a third party class-- formats a given SQL query for better visibility.
1. [String Helper](components-string-helper.md) contains all the utilities for formatting, correcting and shaping strings for saving or showing.
1. [View Helper](components-view-helper.md) contains all the utilities required for simpler and better view of objects in output. 


#Columns
Columns are classes extending \kartik\grid\ActionColumn instead of \yii\grid\ActionColumn.
They are specialized versions for Kartik Gridview.

1. [Action Column](columns-action-column.md) contains ActionColumn for GridViews.
1. [Boolean Column](columns-boolean-column.md) contains BooleanColumn for GridViews.
1. [Data Column](columns-data-column.md) contains DataColumn for GridViews.
1. [Enum Column](columns-enum-column.md) contains EnumColumn for GridViews.
1. [Radio Column](columns-radio-column.md) contains RadioColumn for GridViews to select row and work with bulk action.


#Models
1. [Base Model](models-khan-model.md) contains basic skeleton for all models.
1. [Base user](models-khan-user.md) contains basic skeleton for all user models.
1. [CSV DataProvider](models-csv-data-provider.md)


#RBAC
1. Helpers:
   1. view by path
   1. view by user
1. Rules predefined rules:
   1. [Owner Rule](rbac-rule-owner.md)


#Widgets
1. [Date Picker](widgets-date-picker.md)
1. [Date Range Picker](widgets-date-range-picker.md)
1. [Grid View](widgets-grid-view.md)
1. [Export Menu](widgets-export-menu.md)

   
#Others
These are miscellaneous classes for configuring the package or installation.

1. [VarDump](components-var-dump.md) contains methods to make life easier and fun for the admins in debugging the code objects.
1. [SqlFormatter](components-sql-formatter.md) contains methods to make life easier and fun for the admins in debugging the SQL queries.
1. [Settings](settings.md) contains all the settings and constant values.
1. [Migrations](helpers-migrations.md) contains all the migrations required for rising the package up and running.
1. [Overlay Menu](widgets-menu.md) contains description of an overlay menu, which covers all the browser page.
This can be used inside _**NavBar**_ menu or as a button on the page.
 
#StartUp
General requirements in application options:

```php
    'language' => 'fa-IR',
    'timeZone' => 'Asia/Tehran',
    'aliases' => [
        '@khan' => '@vendor/khans465/yii2-utils',
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
        ],
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
        'session' => [
            'name' => '_staff_session',
            'savePath' => __DIR__ . '/../runtime/sessions',
            //'class' => 'yii\web\DbSession',
            //'sessionTable' => 'sys_session_staff',
            'cookieParams' => [
                'httpOnly' => true,
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'kvgrid' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
                'ruleTable' => 'sys_auth_rule',
                'itemTable' => 'sys_auth_item',
                'itemChildTable' => 'sys_auth_item_child',
                'assignmentTable' => 'sys_auth_assignment',
            ],
            'user'         => [
                'identityClass'   => 'app\models\User',
                'enableAutoLogin' => true,
            ],
            'user' => [
                'identityClass' => 'mdm\admin\models\User',
                'loginUrl' => ['admin/user/login'],
            ]
            //'user' => [
                //'class' => '\khans\utils\models\KHanUser',
                //'identityClass'   => '\khans\utils\models\KHanIdentity',
                //'userTable' => 'a_user',
                //'superAdmins' => ['keyhan'],
                //'enableAutoLogin' => true,
                //'identityCookie' => [
                    //'name' => '_identity_name_',
                    //'httpOnly' => true,
                    //'path' => '_path_to_application_',
                //],
            //],
        ],
        'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                'site/index',
                'site/login',
                'site/error',
            ]
        ],
        ...
     ],
```
params:
```php
'mdm.admin.configs' => [
        'menuTable' => 'sys_menu',
        'userTable' => 'sys_user',
    ],
```
config.console
```php
 'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'sys_migration',
        ],
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
    '\khans\utils\components\StringHelper',
    'screenInput',
],
```
###RBAC Setup
Add following code to `component` section of application options in order to setup AuthManager tables:
   + Setting `identityClass` is not necessary, `KHanUser` has set this value to `\khans\utils\models\KHanIdentity`
   + `class` should be set to one of the child classes of `\khans\utils\models\KHanUser` and **NOT** itself.
   This class should implement `public static function tableName()`
 
```php
'user' => [
    'class' => '\app\models\UserTable',
    //'identityClass'   => '\khans\utils\models\KHanIdentity',
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

Run `./yii migrate/up --migrationPath=@khan/src/helpers/migrations ` to build required tables with the given names.
