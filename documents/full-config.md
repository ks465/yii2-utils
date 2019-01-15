#Full Config
Contains the full detailed config for the applications.

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
'@khan' => '@vendor/khans465/yii2-utils',
'@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
```
###YII_ENV_DEV
+ Require the `VarDump.php` in order to debug variables and queries.
+ Add GII generators to automate building of code. 
```php
if (YII_ENV_DEV) { 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'model'      => [
                'class'     => 'khans\utils\helpers\generators\model\Generator',
                'templates' => [
                    'default' => '@khan/src/helpers/generators/model/default',
                    ],
            ],
            'form'       => [
                'class'     => 'khans\utils\helpers\generators\form\Generator',
                'templates' => [
                    'default' => '@khan/src/helpers/generators/form/default',
                ],
            ],
            'controller' => [
                'class'     => 'khans\utils\helpers\generators\controller\Generator',
                'templates' => [
                    'default' => '@khan/src/helpers/generators/controller/default',
                ],
            ],
            'crud'       => [
                'class'     => 'khans\utils\helpers\generators\crud\Generator',
                'templates' => [
                    'default' => '@khan/src/helpers/generators/crud/ajax',
                    'giiCrudList' => '@khan/src/helpers/generators/crud/grid',
                    'giiCrudUser' => '@khan/src/helpers/generators/crud/user',
                    'giiCrudAuth' => '@khan/src/helpers/generators/crud/auth',
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
}
```
