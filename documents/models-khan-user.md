#KHanUser Class
Documentation Edition: 1.1-971112
Class Version: 0.4-1-971111

The user table(s) in the database have structure like this:

```sql
CREATE TABLE `user` (
  `id`                   INT(11)      PRIMARY KEY,
  `username`             VARCHAR(63)  NOT NULL,
  `auth_key`             VARCHAR(32)  NOT NULL,
  `password_hash`        VARCHAR(127)  NOT NULL,
  `password_reset_token` VARCHAR(127) DEFAULT NULL,
  `access_token`         VARCHAR(127) DEFAULT NULL,
  `name`                 VARCHAR(63)  NOT NULL,
  `family`               VARCHAR(127) NOT NULL,
  `email`                VARCHAR(127) NOT NULL,
  `status`               TINYINT(1)   NOT NULL,
  `last_visit_time`      INT(11)      NOT NULL,
  `create_time`          INT(11)      NOT NULL,
  `update_time`          INT(11)      NOT NULL,
  `delete_time`          INT(11)      NOT NULL
)
```

Set the user component of the application like following:

```php
'user' => [
    'class' => '\khans\utils\models\KHanUser',
    'identityClass'   => '\khans\utils\models\KHanIdentity',
    'userTable' => 'a_user',
    'superAdmins' => ['keyhan'],
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => '_identity_name_',
        'httpOnly' => true,
        'path' => '_path_to_application_',
    ],
],
``` 

The model has two extra fields:
+ fullName name and family of the user
+ fullId name, family and user ID of the user

`getIsSuperAdmin` (`isSuperAdmin`) calls the same method in the identity class.
This class is also responsible for setting `last_visit_time` in the user table.

Remember to set `Yii::$app->params['user.passwordResetTokenExpire']`.
