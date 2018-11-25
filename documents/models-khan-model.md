#KHanModel Class
Documentation Edition: 1.0-970825

Class Version: 0.4.2-970803

All of the standard globally required methods and properties are set here for simplicity.
Some of these methods are gathered in the main model, and some are in the accompanied [[KHanS\Utils\models\queries\KHanQuery|query]]
The most important items are:

1. Disabling **Delete** method and replace it with status-changing method.
1. Adding **BlameAble** and **TimeStamp** behaviors to automatically record the creation and update time and user.
1. The status field shows how to filter (or when to show) the item:
   + **KHanModel::STATUS_DELETED** shows the record is totally out of reach of every user and method except for the `Super Admin`. 
   + **KHanModel::STATUS_PENDING** shows the record is out of order. No record in other models can choose the value of this record 
for creating or updating values. But whenever there is need to _show data of other_ records which depend in this one,
data is available. 
   + **KHanModel::STATUS_ACTIVE**  shows data is completely available for updating, using in other data sets, etc.
1. Methods to find the creater, last updater, and time of each.
   + If there is more than one table holding users --like pGrad-- change:
       - [[KHanS\Utils\models\KHanModel::getResponsibleUser]] to be able to see all the users in the above methods, 
       - [[KHanS\Utils\helpers\migrations\KHanMigration::$user_models]] to create all the tables and models,

For details see [[KHanS\Utils\models\KHanModel]] and [[KHanS\Utils\models\queries\KHanQuery]]

A `sqlite` database is ready in the `demos` directory, which contains all models needed for the demos. In order to activate it,
load `db` component as follows:

```php
'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/db/database.db',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
],
```
