#Workflow
Documentation Edition: 1.0-970820
Class Version: 


This document mostly deals with workflow manager when data is kept in database.
*__Structure of workflow definition providers is also discussed here.__*
For more information about usage see:
1. [WorkflowBehavior](behaviors-workflow-behavior.md) for behavior in the models.
1. [Progress Column](workflow.md#ProgressColumn) for columns in `GridView`.
1. [WorkflowField](widgets-workflow-field.md) for input fields of the forms.

There is a good demo in the `demos` module.

#Workflow Manager
In this version workflow are saved in the database tables and managed using [[\cornernote\workflow\manager\Module]].
Both [[workflow]] and [[workflow-view]] are supported through this.
Although it is not ver good for building new workflow from scratch. 
Name of tables are hard-coded.

```php
'modules'    => [
    'workflow' => [
        'class' => 'cornernote\workflow\manager\Module',
    ],
],
'components' => [
    'wizflowManager' => [
        'class' => 'khans\utils\components\workflow\WizflowManager',
        'workflowSourceName' => 'workflowSource',
    ],
    'workflowSource' => [
        'class' => 'cornernote\workflow\manager\components\WorkflowDbSource',
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