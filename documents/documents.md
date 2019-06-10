Documentation Edition: 1.1-971112

This file contains all the useful and important commands and hints from _manuals_, *guides*, **user documentation**, __etc.__

While Yii2 supports MariaDB through its MySQL driver, the differences between MariaDB and MySQL are increasing. At this time the driver included in Yii2 will not properly detect JSON columns in MariaDB and will not properly store data in them.
The goal of this library is to implement the MariaDB specific changes required to get all features working in MariaDB that are supported in the Yii2 core library for other DBMSes.
https://github.com/sam-it/yii2-mariadb


#Composer
1. Use the following command to update class structure of a package in `vendor` directory:

```bash
composer -vv -o dump-autoload
```

#PhpDoc
Run the following command to generate **API documentations**:

```bash
../bin/apidoc api yii2-utils/ yii2-utils/docs --exclude='docs,documents,tests' --page-title=KHanUtils --interactive=0 --guide=../guide
../bin/apidoc api yii2-utils/,vendor/yiisoft/yii2 yii2-utils/docs --exclude='vendor,docs,documents,tests' --page-title=KHanUtils --interactive=0 --guide=../guide

```
The later command includes complete hierarchy, hopefully without generating the duplicated documents for those other packages.


Run the following command to generate **_user guides_**:

```bash
../bin/apidoc guide yii2-utils/documents yii2-utils/guide --page-title=KHanUtils --interactive=0 --guide-prefix= --apiDocs=../docs
../bin/apidoc guide yii2-utils/documents yii2-utils/guide --template=pdf --page-title=KHanUtils --interactive=0 --apiDocs=../docs 
```
The later will generate `.tex` file for creating pdf version of the guide.
 
All commands are presumed to be ran from the package top directory.

The following code is saved in `_create-docs.sh_` in the `_khans465_` directory:

```bash
#!/bin/bash

../bin/apidoc guide yii2-utils/documents yii2-utils/docs --page-title=KHanUtils --interactive=0 --guide-prefix=g_ api-docs=yii2-utils/docs

../bin/apidoc api yii2-utils/src yii2-utils/docs --page-title=KHanUtils --interactive=0 --guide-prefix=g_ api-docs=yii2-utils/docs
``` 

#Tests
There are two sets of tests for this package. One is standard tests in `Codeception` and the other is demos.

###Codeception
1. Run all codeception unit tests from the package root *vendor/khans465/yii2-utils:

```bash
../../bin/codecept generate:test unit khans\utils\ViewHelper
```
2. Create tests using  `_create-tests.sh_` in the `_khans465_` directory:

```bash
#!/bin/bash
cd yii2-utils

echo ../../bin/codecept generate:test unit khans\utils\components\ArrayHelper

../../bin/codecept run unit KHanSUtilsComponentsArrayHelperTest
```

###Demonstration Tests
The `/demos` is a demonstration site using a separate --SQLite-- database to demostrate use the utilities and tools in real scenarios.
 Run as follows for yourself.
