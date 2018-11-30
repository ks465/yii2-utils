#KHanUser Class
Documentation Edition: 1.0-970803

Class Version: 0.3-970803

#*Add RBAC models connection*

Generic User *_identity_* model which implements yii\web\IdentityInterface and extends [KHanModel](guide:models-khan-model.md).
In addition to required methods in the interface, methods of a typical User model is also implemented.
Besides a unique method for accessing full name of the user is also available.


The user table(s) in the database has structure like this:

```sql
CREATE TABLE `user` (
  `id`                   INT(11)      PRIMARY KEY,
  `username`             VARCHAR(63)  NOT NULL,
  `name`                 VARCHAR(63)  NOT NULL,
  `family`               VARCHAR(127) NOT NULL,
  `gender`               TINYINT(1)   NOT NULL,
  `email`                VARCHAR(127) NOT NULL,
  `password`             VARCHAR(63)  DEFAULT NULL,
  `auth_key`             VARCHAR(32)  NOT NULL,
  `password_hash`        VARCHAR(127)  NOT NULL,
  `access_token`         VARCHAR(127) DEFAULT NULL,
  `password_reset_token` VARCHAR(127) DEFAULT NULL,
  `status`               TINYINT(1)   NOT NULL,
  `create_time`          INT(11)      NOT NULL,
  `update_time`          INT(11)      NOT NULL,
  `delete_time`          INT(11)      NOT NULL,
  `last_login_time`      INT(11)      NOT NULL
)
```

set `Yii::$app->params['user.passwordResetTokenExpire']`
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
