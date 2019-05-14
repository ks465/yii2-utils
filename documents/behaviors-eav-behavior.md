#EavBehavior
Documentation Edition: 1.1-980224
Class Version: 0.2.1-980219

This document is only explaining the _behavior_ used to change the model.
As this behavior only changes the model, searching Entities utilizing the EAV attributes 
could not implemented here. 
For required changes in query see [EAV Trait](behaviors-eav-trait.md).
For more details about EAV pattern see [EAV Concept](concept-eav.md).

Class EavBehavior adds the following properties to the owner model:
+ `$id` is name of _table_ in the owner model. This may seems redundant, but it is added for 
simplifying the query trait.
+ `$_attributes` contains list of extra attributes saved in the system attributes table.
+ `$_values` contains values of the attributes for this very record saved in the system attributes values table.
+ `$labels`contains labels for the extra attributes. This is primarily used in the
+ `attributeLabels()` method to complete the list of attribute labels.
+ `getFullAttributes()` method to get values for all attributes, not only the internal model data.

Class EavBehavior is the actor behind following EAV actions:
+ `List/Grid View` shows these attributes very much like normal attributes.
+ `View` shows these attributes very much like normal attributes.
+ `Edit` updates values in the system attributes values table after editing (inserting or updating)
the owner record.
+ `Delete` delete the value after deleting the main record.

The following changes are required for the model to utilize the pattern:
```php
    public function behaviors(): array
    {
        return array_merge([
            'EAV' => [
                'class' => '\khans\utils\demos\data\EavBehavior',
                'id'    => 'multi_format_data',
            ],
        ], parent::behaviors());
    }
    public function attributeLabels(): array
        {
            return parent::attributeLabels() + $this->_labels + [
                //model specific labels
            ];
        }
```