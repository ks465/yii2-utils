#Full Config
Documentation Edition: 1.3-971126

Contains the full detailed config for the applications.
The full config is divided into two sections:
1. _General Setting_: All the settings for normal working of the applications.
1. _Admin Setting_: Settings only applicable when the Admin is logged in.

**_Notice:_** You need both `supportEmail` and `adminEmail` to be set.

##Main Layout File of each Application
There is a spinner, which is activated on page loadings. It is a very good representation showing the 
user wait for the activated action. To setup it, add following to `layout/main.php` of applications.
This implementation is NOT blocking, and users can do whatever they want and omit the previous action.
```php
use kartik\spinner\SpinnerAsset;
SpinnerAsset::register($this); 
```
```html
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div id="spinner-frame" style="position: fixed; margin-top: 250px; width: 100%;">
            <div id="spinner-span" style="width: 10%;" class="center-block text-center"></div>
        </div>
...
```

##Console.config
###Components

##Web.config
###Components

```php
'user' => [
    'class' => '\khans\utils\models\KHanUser',
    'identityClass'   => '\khans\utils\models\KHanIdentity',
    'loginUrl' => ['system/auth/login'],
    'userTable' => 'sys_users_staff', //use same model with different tables for different applications
    'superAdmins' => ['keyhan'],
    'enableAutoLogin' => false, // for REST server set these two enable* to false
    'enableSession' => false,
    'identityCookie' => [
        'name' => '_identity_name_',
        'httpOnly' => true,
        'path' => '_path_to_application_',
    ],
],
```

##Common
```php
'language' => 'fa-IR',
'timeZone' => 'Asia/Tehran',
```

###Aliases

```php
'@khan' => '@vendor/khans465/yii2-utils/src',
'@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
```

###YII_ENV_DEV

+ Require the `VarDump.php` in order to debug variables and queries.
+ Add GII generators to automate building of code. 
```php
if (YII_ENV_DEV) { 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
     $config['components']['errorHandler'] = ['errorAction' => 'khan/default/error'];
   
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'component'  => [
                'class'     => 'khans\utils\helpers\generators\component\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/component/default',
                ],
            ],
            'model'      => [
                'class'     => 'khans\utils\helpers\generators\model\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/model/default',
                    'giiEavModel' => '@khan/helpers/generators/model/eav',
                ],
            ],
            'form'       => [
                'class'     => 'khans\utils\helpers\generators\form\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/form/default',
                ],
            ],
            'controller' => [
                'class'     => 'khans\utils\helpers\generators\controller\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/controller/default',
                ],
            ],
            'crud'       => [
                'class'     => 'khans\utils\helpers\generators\crud\Generator',
                'templates' => [
                    'default' => '@khan/helpers/generators/crud/ajax',
                    'giiCrudList' => '@khan/helpers/generators/crud/grid',
                    'giiCrudUser' => '@khan/helpers/generators/crud/user',
                    'giiCrudAuth' => '@khan/helpers/generators/crud/auth',
                ],
            ],
        ],
    ];
}
```

###YII_DEBUG
+ Require the `VarDump.php` in order to debug variables and queries.
```php
if (YII_DEBUG) { 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');

    $config['components']['errorHandler'] = ['errorAction' => 'khan/default/error'];
}
```
