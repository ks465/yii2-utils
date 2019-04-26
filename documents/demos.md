#Demos
Documentation Edition: 1.1-980202

The module id to connect to the tools module is `demos`.

Example: 
```
http://localhost/application/web/index.php/demos
```

A `sqlite` database is ready in the `demos` directory, which contains all models needed for the demos. In order to activate it,
load `db` component as follows:

```php
'test' => [
    'class'   => 'yii\db\Connection',
    'dsn'     => 'sqlite:@khan/demos/data/test-data.db',
    'charset' => 'utf8',
],
```

You should add this to the config file.
```php
if (YII_ENV_DEV) {
    $config['modules']['demos'] = [
        'class' => 'khans\utils\demos\Module',
    ];
}
```

#List of available demos
