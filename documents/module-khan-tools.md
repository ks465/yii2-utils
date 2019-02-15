#Module Tools
Documentation Edition: 1.2-971122
Class Version: 0.4-1-971111

+ Error handler for admin: Render debugging information for Admin upon errors.

```php
if (YII_ENV_DEV) {
    require_once(__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
    
    $config['components']['errorHandler'] = ['errorAction' => 'khan/default/error'];
...
```

+ History
   - *User login history* contains all login attempts to the site
   - *Record change history* contains all the changes in the models extending [[KHanModel]]
+ EAV
   - *Attributes* contains CRUD for _all_ attributes used in EAV patterns
   - *Values* contains CRUD for _all_ values used in EAV patterns
