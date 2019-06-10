#Tests
Documentation Edition: 1.2-980310

Set the following in the `config/test.php`. Test are designed to extrcact required type from these. 

```php
'components' => [
	...
	'user' => [
		'identityClass' => 'app\models\User',
	],
	'user_table' => [
	    'class'         => 'khans\utils\models\KHanUser',
	    'identityClass' => 'khans\utils\models\UserTable',
	    'userTable'     => 'sys_users',
	    'loginUrl'      => ['/khan/auth/login'],
	    'superAdmins'   => ['keyhan'],
	],
	'user_array' => [
	    'class'         => 'khans\utils\models\KHanUser',
	    'identityClass' => 'khans\utils\models\UserArray',
	    'userTable'     => 'sys_users', //this is here to ensure LoginFormTest:testLoginCorrectTable works in this config
	    'loginUrl'      => ['/khan/auth/login'],
	    'superAdmins'   => ['keyhan'],
	],
	...
],
...
'as beforeRequest' => [
    'class' => 'yii\filters\AccessControl',
    'rules' => [
        [
            'actions' => ['login', 'error', 'index'], //you need to have a controller and an action site/login
            'allow' => true, //because this gets called if the user is not logged in and no rule applies.
        ],
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
],
```

And `config/test_db.php` as follows:

```php
return [
    'class'   => 'yii\db\Connection',
    'dsn'     => 'sqlite:@khan/demos/data/test-data.db',
    'charset' => 'utf8',
];
```

```bash
cd vendor/khans465/yii2-utils

../../bin/codecept build
```

###Unit Tests:
unit.suite.yml:

```yaml
actor: UnitTester
modules:
	enabled:
		- Asserts
		- \Helper\Unit
		- Yii2:
            part: [orm, email]
```

These tests are generated as following:

```bash
vendor/bin/codecept run unit vendor/khans465/yii2-utils/tests
```
And you have an empty test named `khansutilscomponentsArrayHelperTest` in `tests/unit` directory. Rename it as you like.

And for running the tests use:

```bash
# Run all unit tests:
vendor/bin/codecept run unit
```

There multiple test files in the `tests/_data` directory which are utilized in the tests.
There are also tests utilizing the test SQLite database in `demos` module.

###Functional Tests:
functional.suit.yml

```yaml
actor: FunctionalTester
modules:
    enabled:
        - Filesystem
        - Yii2
```

And for running the tests use:

```bash
# Run all unit tests:
vendor/bin/codecept run unit vendor/khans465/yii2-utils/tests
```

###Acceptance Tests:
acceptance.suit.yml

```yaml
class_name: AcceptanceTester
modules:
	enabled:
		- WebDriver
			url: 'http://127.0.0.1/khans/web/index.php'
			browser: chrome
		- Yii2:
			part: orm
           entryScript: index-test.php
           cleanup: false
```

```bash
vendor/bin/codecept run unit vendor/khans465/yii2-utils/tests
```

And for running the tests use:

```bash
# Run all unit tests:
vendor/bin/codecept run unit vendor/khans465/yii2-utils/tests
```



Selenium Server Console Address is:
`http://localhost:4444/wd/hub`