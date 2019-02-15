#EavBehavior
Documentation Edition: 1.0-971126
Class Version: 0.1.2-971125

EAV pattern is used for models which resemble sparse matrices. Instead of adding more fields to a single table, these attributes are listed in the Attribute table. By changing any Entity record, the Values of these attributes are saved in a third table.
As this behavior only changes the model, searching Entities utilizing the EAV attributes could not implemented here. For searching and querying EAV entities, see [EavQueryTrait](behaviors-eav-trait.md)  

Class EavBehavior is the actor behind following EAV actions:
+ `List/Grid View`
+ `View`
+ `Edit`
+ `Delete`
