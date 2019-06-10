#Tools
Documentation Edition: 1.1-980202

The module id to connect to the tools module is `khan`.

Example: 

```
http://localhost/application/web/index.php/khan
```

You should add this to the config file.

```php
if (YII_ENV_DEV) {
    $config['modules']['khan'] = [
        'class' => 'khans\utils\tools\Module',
    ];
}
```

#List of available tools
