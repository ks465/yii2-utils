#RelatedColumn
Documentation Edition: 2.0-980206
Class Version: 0.2.0-980122

RelatedColumn adds a column with Select2 filter and sort a column in foreign key reference.
For more information about the concept see [Parent Child Pattern](concept-parent-child.md).

Required configurations are:
+ `class => '\khans\utils\columns\RelatedColumn',` 
+ `attribute` name of the field in child table referring the parent PK
+ `parentController` **Required** path to the controller responsible for parent actions.
This is used to link the relating column to the parent view page.
+ `value` accepts closures as usual.
+ `group` defaults to true. This makes the grouping active **if** the grid view is sorted by the column.

Searching the column is based on the field named in `$titleField`.
