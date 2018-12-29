#Full Config
Contains the full detailed config for the applications.


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
'language' => 'fa-IR',
```
###Aliases
```php
'@khan' => '@vendor/khans465/yii2-utils',
'@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
```
###YII_ENV_DEV
```php
if (YII_ENV_DEV) { 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
}
```
###YII_DEBUG
```php
if (YII_DEBUG) { 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
}
```
