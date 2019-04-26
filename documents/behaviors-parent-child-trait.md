#ParentChildTrait
Documentation Edition: 1.0-980202
Class Version:  0.1.0-980121

The concept of Parent Child Pattern is defined in [this document](concept-parent-child.md). 
Here only 

This trait should be used by both models to complete the relation. 

The parent model should use this trait and set these two properties:
```php
use ParentChildTrait;
private static $titleField = 'name_of_field_in_parent_model_act_as_a_title_for_each_record';
private $childTable = \path\to\ChildModel::class;
```
 + _titleField_ is name of a column in the parent model containing a descriptive value which hints
 the user which record it is. This field will be searched in child grid view.
 + _childTable_ is the **model** representing the child record.
  
The child model should use this trait and set these two properties:
```php
use ParentChildTrait;
private static $linkFields = ['reference_key_to_parent_record'];
private $parentTable = '\path\to\ParentModel';
```
 + _linkFields_ is an array of name(s) of column(s) in the child model containing fields referencing primary key(s) 
 of the parent.
 + _parentTable_ is the **model** representing the parent record.
  
By setting these properties appropriately, the CRUD generator can add the following components to 
relative places:
[RelatedColumn](columns-related-column.md) to the _columns.php of the child index page.
[Select2]() to the _form.php of the child pages for the linkFields.
[GridView](widgets-grid-view.md) to the view.php page of the parent controller.

There is special [generator](helpers-genrators.md) --which is not available in web GII-- 
which generates **ALL** the models and CRUD simultaneously.

This trait offers the following methods:
+ _getParentTable()_ (static) return the property `$parentTable` for child model.
+ _getChildTable()_ (static) return the property `$childTable` for the parent model.
+ _getLinkFields()_ (static) return array of reference fields `$linkFields` in the child model.
+ _getTitleField()_ (static) return the `$titleField` in the parent model.
+ _getParent()_ return a KHanQuery defining parent active record for this record of child.
+ _getParentTitle()_ return content of the title field of the parent active record. 
+ _getChildren()_  return a KHanQuery defining children active records for this record of parent. 
