##AAA
Documentation Edition: 1.0-980308

###User Model
+ khans\utils\models\KHanUser

###User Identity Models
+ khans\utils\models\UserArray for a few users saved in an array inside the identity model.
This type does not support and access control. Any and every logged-in user has full access to all of resources by default.

+ khans\utils\models\UserTable for table based large number of users.
This type uses RBAC by using `mdmsoft/yii2-admin` in full power.

When using array based user model, add the following **BELOW** `component` in config file to force login for all pages as simple as possible:

```php
// 'as someNameHere' => ... is the syntax for adding behaviors.
   'as beforeRequest' => [ 
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error', 'captcha'], //you need to have a controller and an action site/login 
                'allow' => true, //because this gets called if the user is not logged in and no rule applies.
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
```