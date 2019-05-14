#KHanModel Class
Documentation Edition: 1.3-980224
Class Version: 0.4.10-980224

All of the standard globally required methods and properties are set here for simplicity.
Some of these methods are gathered in the main model, and some are in the accompanied [[khans\utils\models\queries\KHanQuery|query]]
The most important items are:

1. Listing errors in validating a model in text format
1. Disabling **Delete** method and replace it with status-changing method.
1. **Save** method forcefully validates the attributes. If validation succeeds, a `flash` message is added to session. If validation fails, the model errors are added to `flash` message.
1. Adding **BlameAble** and **TimeStamp** behaviors to automatically record the creation and update time and user.
1. The status field shows how to filter (or when to show) the item:
   + **KHanModel::STATUS_DELETED** shows the record is totally out of reach of every user and method except for the `Super Admin`. 
   + **KHanModel::STATUS_PENDING** shows the record is out of order. No record in other models can choose the value of this record 
for creating or updating values. But whenever there is need to _show data of other_ records which depend in this one,
data is available. 
   + **KHanModel::STATUS_ACTIVE**  shows data is completely available for updating, using in other data sets, etc.
1. Methods to find the creator, last updater, and time of each.
   + If there is more than one table holding users --like pGrad-- change:
       - [[khans\utils\models\KHanModel::getResponsibleUser]] to be able to see all the users in the above methods, 
       - [[khans\utils\helpers\migrations\KHanMigration::$user_models]] to create all the tables and models,
1. `isActive` Shows if the status of the record is equal to `KHanModel::STATUS_ACTIVE`
1. `isVisible` Shows if the status of the record is _**NOT**_ equal to `KHanModel::STATUS_DELETED`
1. `getLastFlow` shows the updated time
1. `getActionHistory` returns list of changes in the record through the history data, 
including changes in EAV data.
1. The `$tableComment` holds a definition for the table. 
This is set to table comment by the model generators.
It is primarily used for titles of the action pages in generated CRUD.

For details see [[khans\utils\models\KHanModel]] and [[khans\utils\models\queries\KHanQuery]]
