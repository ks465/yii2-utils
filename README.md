
Personal Utilities for Simpler Coding
=====================================
A pack of multiple components and widgets, especially designed for simpler and more generic coding [repository]


#Test Install
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

#Installation

The preferred way to install this extension is through [composer].

Either run

```
php composer.phar require --prefer-dist khans465/yii2-utils "*"
```

or add

```
"khans465/yii2-utils": "*"
```

to the require section of your `composer.json` file.

#Usage

The Test* files in *tests* directory show all possible usage for the package. Each file has a ```runAllTests``` method
which you can use to see everything this class does.


#Documentation

 1. [Installation](README.md)
 1. [Documents](documents.md)
 2. [Guide](guide.md)
 2. [Columns](columns.md)
 
 

  
Test debug utilities:
```
$tester = new \khans\utils\tests\TestAdmin();
$tester->runAllTests();
```

Test components:
```
$tester = new \khans\utils\tests\TestComponents();
$tester->runAllTests();
```

Test widgets:
```
$tester = new \khans\utils\tests\TestWidgets();
$tester->runAllTests();
```

[repository]: https://github.com/ks465/yii2-utils
[composer]: http://getcomposer.org/download/
