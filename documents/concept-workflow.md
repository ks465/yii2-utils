#Workflow
Documentation Edition: 1.1-980330
Class Version: 


This document mostly deals with workflow manager when data is kept in database.
*__Structure of workflow definition providers is also discussed here.__*
For more information about usage see:
1. [WorkflowBehavior](behaviors-workflow-behavior.md) for behavior in the models.
1. [Progress Column](workflow.md#ProgressColumn) for columns in `GridView`.
1. [WorkflowField](widgets-workflow-field.md) for input fields of the forms.

There is a good demo in the `demos` module.

###Mixed definitions
+    If the transition needs sending emails, it would be written to `sys_history_email` table.
+    Using mixed workflow prohibits selecting of `workflow status` by user upon creating a new record.
    It should be done in the code by defining the workflow ID and initial status at the same time based on designed strategy.
+    After registering to a specific workflow, the record always belongs to that workflow.
    So changing states is possible only in that workflow.
+    Labels of states in different definitions may be the same. In this case the state IDs are not the same, however.
    Hence filtering the columns and grid views could not be done in a generic form. It should be designed for each scenario.


###buttons.php
This view file is a view file showing a button group for all defined transitions

#Workflow Manager
In this version workflow are saved in the database tables and managed using [[\cornernote\workflow\manager\Module]].
Both [[workflow]] and [[workflow-view]] are supported through this.
Although it is not ver good for building new workflow from scratch. 
Name of tables are hard-coded.

```php

?'modules'    => [
?    'workflow' => [
?        'class' => 'cornernote\workflow\manager\Module',
?    ],
?],
'components' => [
?    'wizflowManager' => [
?        'class' => 'khans\utils\components\workflow\WizflowManager',
?        'workflowSourceName' => 'workflowSource',
?    ],
X    'workflowSource' => [
X        'class' => 'cornernote\workflow\manager\components\WorkflowDbSource',
X    ],
    'workflowSource' => [
        'class' => 'raoul2000\workflow\source\file\WorkflowFileSource',
        'definitionLoader' => [
            // use return [...] syntax:
            'class' => 'raoul2000\workflow\source\file\PhpArrayLoader',
            'path'  => '@app/models/workflow',
            // use WorkflowClass implements IWorkflowDefinitionProvider syntax:
            'class' => 'raoul2000\workflow\source\file\PhpClassLoader',
            'namespace'  => 'app\\models\\workflow'
        ]
    ],
    ],
```

```php
class Post extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => \raoul2000\workflow\base\SimpleWorkflowBehavior::className(),
                'defaultWorkflowId' => 'post',
                'propagateErrorsToModel' => true,
            ],
        ];
    }
}
```

##Workflow Structure
- [x] id :string status ID
- [x] label :string label of the status
- [x] transitions :array list of statuses allowed to transit into
- [x] metadata :array following items
   + [x] email :boolean|string|closure|null the condition for sending email upon entering this status
   + [x] description :string detail of the status
   + [ ] actor :string one of predefined actors
   + [ ] stage :array list of groups of statuses
   + [ ] color :string color coding for texts or buttons
   + [ ] icon :string icon used in buttons and links
   + [ ] action :closure used to run arbitrary code on workflow transition
   
\* Mandatory configs are checked. 

#WorkflowField
This widget renders a Select2 input widget for gathering input. 
The most important convenience is to set the model to inherit [[KHanModel]].
 As a result the `data` config utilizes [[KHanModel::getWorkflowState()]] which indeed is a method in the [[WorkflowBehavior]].

```php
$form = ActiveForm::begin();

echo $form->field($this->WFRecord, 'progress_column')->widget(WorkflowField::class, []);

echo Html::submitButton('Send');
ActiveForm::end();
```

#WorkflowBehavior

+ [getWorkflowState()] get label for the current record.
+ [getStatusesLabels()] get a list for drop-downs of all of the statuses in the given workflow.
+ [$statusTable] name of table containing all statuses. 
+ [workflowID] ID of the workflow which the model is part of.


#WorkflowButtons

Show group of buttons based on defined transitions of the current status. Class and glyph icon are read from the 
workflow definition. Uses [KHanWorkflowHelper::getAllowedStatusesByRole] for checking the access level of the user 
to the target statuses based on the defined roles.

```php
\khans\utils\components\workflow\WorkflowButtons::widget([
    'model' => $model,
    'name' => 'name-attribute-of-buttons',
])
```

#ProgressColumn

By defining the `workflow` (class implementing `IWorkflowDefinitionProvider`),
the following column will render workflow labels in the cells, 
and show Select2 filter searching workflow labels. 

```php
[
    'attribute' => 'progress_column',
    'class'     => 'khans\utils\columns\ProgressColumn',
],
```

The search models bypass `behaviors()` models to stop nasty error messages
