#KHanModel Class
Documentation Edition: 1.0-970803

Class Version: 0.4-970803

All of the standard globally required methods and properties are set here for simplicity.
The most imprtant items are:

1. Disabling **Delete** method and replace it with status-changing method.
1. Adding **BlameAble** and **TimeStamp** behaviors to automatically record the creation and update time and user.
1. The status field shows how to filter (or when to show) the item:
   + **KHanModel::STATUS_DELETED** shows the record is totally out of reach of every user and method except for the `Sper Admin`. 
   + **KHanModel::STATUS_PENDING** shows the record is out of order. No record in other models can choose the value of this record 
for creating or updating values. But whenever there is need to _show data of other_ records which depend in this one,
data is available. 
   + **KHanModel::STATUS_ACTIVE**  shows data is completely available for updating, using in other data sets, etc.
1. Methods to find the creater, last updater, and time of each.

For details see [[KHanS\Utils\models\KHanModel]]

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
