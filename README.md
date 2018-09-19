c4848079c833bf3155207f757d9e0e8c59b15e51
Personal Utilities for Simpler Coding
=====================================
A pack of multiple components and widgets, especially designed for simpler and more generic coding


Test Install
------------
The next step is just for initial development, skip it if you directly publish the extension on packagist.org

Add the newly created repo to your composer.json.
```
"repositories":[
    {
        "type": "git",
        "url": "https://github.com/ks465/"
    }
]
```
And run
```
composer.phar require khans465/yii2-utils:dev-master
```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist khans465/yii2-utils "*"
```

or add

```
"khans465/yii2-utils": "*"
```

to the require section of your `composer.json` file.


Usage
-----

The Test* files in *tests* directory show all possible usage for the package. Each file has a ```runAllTests``` method
which you can use to see everything this class does.

```
$tester = new \KHanS\Utils\tests\TestDebug();
$tester->runAllTests();
```
