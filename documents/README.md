#Guide
This is document for KHanS/yii2-utils package.

Documentation Edition: 2.3-980212

**_Notice:_** You need both `supportEmail` and `adminEmail` to be set.

#Documentation
Guides, notes, and anything regarding good style programming and documenting:

1. [Document Tips and Tricks](documents.md) Useful data for using documents, demos and also how to update documents and run tests.
1. [Setup for Persian](persian.md) Settings and tweaks for activating and tuning pages for RTL Persian language.
1. [Complete Config](full-config.md) A complete `config.php` file for utilizing full power
1. [Tools](tools.md)
1. [Demos](demos.md)


#Concepts
1. [AAA](concept-aaa.md) Setup for users' login, access control, etc.
1. [Entity Attribute Value](concept-eav.md)
1. [Parent Child Pattern](concept-parent-child.md)
1. [Workflow](concept-workflow.md) Setup for workflow, workflow manager, and workflow components. 

#Actions
1. [Help](actions-help.md)
1. [Table Schema](actions-list-tables.md)
1. [System Users](actions-list-users.md)

#Behaviors
1. [EavBehavior](behaviors-eav-behavior.md)
1. [EavQueryTrait](behaviors-eav-trait.md)
1. [ParentChildTrait](behaviors-parent-child-trait.md)
1. [WorkflowBehavior](behaviors-workflow-behavior.md)
 
#Components
All the classes in the component directory of the package:

1. [Array Helper](components-array-helper.md) contains more methods for transforming and reshaping arrays.
1. [File Helper](components-file-helper.md) contains methods to read and write data in different formats.
1. [Jalali and JalaliX](components-jalali.md) contain Jalali date object creation and manipulation.
1. [Math Helper](components-math-helper.md) contains methods to do some mathematical routines easier. 
1. [SQL Formatter](components-sql-formatter.md) --a third party class-- formats a given SQL query for better visibility.
1. [String Helper](components-string-helper.md) contains all the utilities for formatting, correcting and shaping strings for saving or showing.
1. [View Helper](components-view-helper.md) contains all the utilities required for simpler and better view of objects in output. 

#Controllers
1. [KHan Console](controllers-khan-console.md) Common methods for console applications.
1. [KHan Rest](controllers-khan-rest.md) Common Method for REST applications.
1. [KHan Web](controllers-khan-web.md) Common methods for web applications.
1. [System Tables](controllers-system-tables.md) Methods for updating System Tables.

#Columns
Columns are classes extending \kartik\grid\ActionColumn instead of \yii\grid\ActionColumn.
They are specialized versions for Kartik Gridview.

1. [Action Column](columns-action-column.md) contains ActionColumn for GridViews.
1. [Boolean Column](columns-boolean-column.md) contains BooleanColumn for GridViews.
1. [Data Column](columns-data-column.md) contains DataColumn for GridViews.
1. [Enum Column](columns-enum-column.md) contains EnumColumn for GridViews.
1. [Jalali Column](columns-jalali-column.md) contains a Jalali date column for GridViews.
1. [Progress Column](workflow.md#ProgressColumn) contains a workflow progress status for GridView.
1. [Radio Column](columns-radio-column.md) contains RadioColumn for GridViews to select row and work with bulk action.
1. [Related Column](columns-related-column.md)
1. [ProgressColumn](columns-progress-column.md)
1. [ArithmeticColumn](columns-arithmetic-column.md)

#Models
1. [Base Model](models-khan-model.md) contains basic skeleton for all models.
1. [Base user](models-khan-user.md) contains basic skeleton for all user models.
1. [Identity](models-khan-identity.md) contains basic skeleton for all user identity models.

#RBAC
1. Helpers:
   1. view by path
   1. view by user
1. Rules predefined rules:
   1. [Owner Rule](rbac-rule-owner.md)


#Widgets
1. [Date Picker](widgets-date-picker.md) renders a widget for gathering date values in Jalali calendar
1. [Date Range Picker](widgets-date-range-picker.md)
1. [Grid View](widgets-grid-view.md)
1. [AJAX Dropdown](widgets-dropdown.md)
1. [Export Menu](widgets-export-menu.md)
1. [Confirm Button](widgets-confirm-button.md)
1. [Captcha](widgets-captcha.md) renders a CAPTCHA widget
1. [ExportMenu](widgets-export-menu.md)
1. [WorkflowField](widgets-workflow-field.md)
1. [Loading Spinner](widgets-spinner.md) render a loading animation, which is activated on each page change
1. [Growl Alert](helpers-alert.md) rendering alerts in two different type by default

   
#Others
These are miscellaneous classes for configuring the package or installation.

1. [App Builder](helpers-app-builder.md) contains methods useful for creating models, controllers, CRUD packages. 
1. [System table Builder](helpers-system-table-builder.md) contains methods to create or update system tables from definitions in the kernel tables
1. [Generators](helpers-genrators.md) contains multiple generator templates for use besides GII.
1. [VarDump](components-var-dump.md) contains methods to make life easier and fun for the admins in debugging the code objects.
1. [SqlFormatter](components-sql-formatter.md) contains methods to make life easier and fun for the admins in debugging the SQL queries.
1. [Settings](settings.md) contains all the settings and constant values.
1. [Migrations](helpers-migrations.md) contains all the migrations required for rising the package up and running.
1. [Overlay Menu](widgets-menu.md) contains description of an overlay menu, which covers all the browser page.
This can be used inside _**NavBar**_ menu or as a button on the page.
1. [Workflow Manager](components-workflow.md) contains all the requirements for builidng, using and managing workflows
1. [Wizard Flow](components-wiz-flow.md)
1. [Tests](tests.md)
1. [Tools Module](module-khan-tools.md) contains a module for some tools
   - History of changes
   - History of login attempts
   - History of sent emails
   - EAV Attributes
   - EAV Values
 
 Move the following to [Full Config](full-config.md):
#StartUp
General requirements in application options:

```php
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
        ],
        'workflow' => [
            'class' => 'cornernote\workflow\manager\Module',
        ],
    ],
    'components' => [
        'workflowSource' => [
            'class' => 'cornernote\workflow\manager\components\WorkflowDbSource',
        ],
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
    ...
    
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'model'     => [
                'class'    => 'khans\utils\helpers\generators\model\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/model/default'
                    'eavModel' => '@khan/helpers/generators/model/eav',
                ],
           ],
           'crud'       => [
               'class'     => 'khans\utils\helpers\generators\crud\Generator',
               'templates' => [
                   'giiCrudAjax' => '@khan/helpers/generators/crud/ajax',
                   'giiCrudRead' => '@khan/helpers/generators/crud/read',
                   'giiCrudList' => '@khan/helpers/generators/crud/grid',
                   'giiCrudUser' => '@khan/helpers/generators/crud/user',
                   'giiCrudAuth' => '@khan/helpers/generators/crud/auth',
               ],
           ],
           'controller' => [
               'class'     => 'khans\utils\helpers\generators\controller\Generator',
               'templates' => ['giiController' => '@khan/helpers/generators/controller'],
           ],
           'form'       => [
               'class'     => 'khans\utils\helpers\generators\form\Generator',
               'templates' => ['giiForm' => '@khan/helpers/generators/form'],
           ],
       ],
    ];
}
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

Run `./yii migrate/up --migrationPath=@khan/helpers/migrations` to build required tables with the given names.
