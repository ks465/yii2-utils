#EavQueryTrait
Documentation Edition: 1.0-971126
Class Version: 0.2.1-980121

This document is only explaining the _trait_ used to change the query.
As this trait only changes the query, setting up the Entities utilizing the EAV attributes 
could not implemented here. 
For required changes in model see [EAV Trait](behaviors-eav-behavior.md).
For more details about EAV pattern see [EAV Concept](concept-eav.md).

Class EavQueryTrait is the actor behind following EAV actions:
+ `getEavJoinQuery`: Builds the required joins for accessing the attributes and corresponding values.
Although this is a public method, it is not expected to be called publicly.
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
