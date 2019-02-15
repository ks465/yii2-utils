#EavQueryTrait
Documentation Edition: 1.0-971126
Class Version: 0.1.1-971125

EAV pattern is used for models which resemble sparse matrices. Instead of adding more fields to a single table, these attributes are listed in the Attribute table. By changing any Entity record, the Values of these attributes are saved in a third table.
As this trait only changes the query, normal actions for the EAV attributes are not implemented here. For creating and changing EAV entities, see [EavBehavior](behaviors-eav-behavior.md)  

Class EavQueryTrait is the actor behind following EAV actions:
+ `getEavJoinQuery`: Builds the required joins for accessing the attributes and corresponding values.
+ `andEavFilterWhere` and `orEavFilterWhere`: By accepting attribute name and a value build conjugated pair of condition for filtering entities based on the given attribute.
+ `andEavFilterCompare` and `orEavFilterCompare`: These methods are similar to the above ones. They accept a third argument as `defaultOperator` and in addition to that they understands the operators at the beginning of the submitted values. These operators are recognized:
- `<`: the column must be less than the given value.
- `>`: the column must be greater than the given value.
- `<=`: the column must be less than or equal to the given value.
- `>=`: the column must be greater than or equal to the given value.
- `<>`: the column must not be the same as the given value.
- `=`: the column must be equal to the given value.
- `!=`: same as `<>`
- `like`: the column must contain the given value as part of string. 
