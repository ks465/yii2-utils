#Tests
Documentation Edition: 1.1-971112

Class Version: 0.4-1-971111

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
```

These tests are generated as following:

```bash
cd vendor/khans465/yii2-utils

../../bin/codecept generate:test unit khans\utils\components\ArrayHelper
```
And you have an empty test named `khansutilscomponentsArrayHelperTest` in `tests/unit` directory. Rename it as you like.

And for running the tests use:

```bash
# Run all unit tests:
../../bin/codecept run unit

# Run a single test:
../../bin/codecept run unit [ASingleFileInTestsUnitDir]
```

There multiple test files in the `tests/_data` directory which are utilized in the tests.
There are also tests utilizing the test SQLite database in `demos` module.

###Functional Tests:


###Acceptance Tests:
acceptance.suit.yml

```yaml
class_name: AcceptanceTester
modules:
	enabled:
		- WebDriver
	config:
		WebDriver:
			url: 'http://127.0.0.1/khans/web/index.php'
			browser: firefox | chrome
```

```bash
cd vendor/khans465/yii2-utils

../../bin/codecept generate:cept acceptance ASingleFileInTestsAcceptanceDir
```

And for running the tests use:

```bash
# Run all unit tests:
../../bin/codecept run acceptance

# Run a single test:
../../bin/codecept run acceptance [ASingleFileInTestsAcceptanceDir]
```



Selenium Server Console Address is:
`http://localhost:4444/wd/hub`