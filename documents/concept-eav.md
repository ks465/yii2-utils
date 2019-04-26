#EAV Pattern
Documentation Edition: 1.0-980205

**E**ntity **A**ttribute **V**alue pattern is used for models which resemble sparse matrices.
Instead of adding more fields to a single table, these attributes are listed in the Attribute table.
By changing any Entity record, the Values of these attributes are saved in a third table.

For setting up the EAV pattern, see [EavBehavior](behaviors-eav-behavior.md)  
For searching and querying EAV entities, see [EavQueryTrait](behaviors-eav-trait.md)  

This requires two system tables for holding attributes and values.
Reading the data is absolutely dynamic and you can disable/ enable any attribute at any time.

In this package two system are required in order to enable this pattern.
One is for saving the defined attributes.
The second is for saving the values set for those attributes.

In the [Tools Module](tools.md) of this package there are two controller for *EAV Attributes*
and *EAV Values*.
The first one is used to define or change the attributes.
This is really required for proceeding the application.
The second shows the set values for all entities.
This one should not really be used by the admin or any body else.
It is only for checking the data. 
