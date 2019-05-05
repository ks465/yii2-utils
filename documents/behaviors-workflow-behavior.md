#WorkflowBehavior Class
Documentation Edition: 1.0-980212
Class Version: 0.2.0-980212


```php
'Workflow' => [
    'class'                  => '\khans\utils\behaviors\WorkflowBehavior',
    'statusAttribute'        => 'progress_column',
    'propagateErrorsToModel' => true,
    'autoInsert'             => false,
    'defaultWorkflowId'      => 'WF',
],
```

These are added methods:
+ readStatusesFromTable If the workflow definitions are kept in database, use this method to read status and labels from table directly.
   **This is in initial testing and may be removed from the package.**
+ getStatusesLabels It is used in [WorkflowField] for options of the select. The return value is array in form `stutus => label`
+ getWorkflowState In the view page use `$model->getWorkflowState()` to simply show the label and the status together: `دوم (WF/Two)`
+ *__shouldSendEmail__* If called from the model (`$model->shouldSendEmail()`), it would return the `email` config in `metadata`.
If it is called in the context of event handling, it would return the value for the end status.

WorkflowValidator is added.
These are added events:

Customized event handler for doing something?
Customized event handler for sending emails.

These are inherited methods:
+ afterDelete
+ afterSaveStatus
+ attach
+ beforeDelete
+ beforeSaveStatus
+ createTransitionItems
+ doAutoInsert
+ ensureStatusInstance
+ enterWorkflow
+ events
+ firePendingEvents
+ getDefaultWorkflowId
+ getEventSequence
+ getNextStatuses Returns list of allowed statuses which the current model can transit into
+ getOwnerStatus
+ getScenarioSequence
+ getStatusAccessor
+ getStatusConverter
+ getWorkflow
+ getWorkflowSource
+ getWorkflowStatus
+ hasWorkflowStatus
+ init
+ initStatus
+ isAttachedTo
+ selectDefaultWorkflowId
+ sendToStatus Use this to change status to an allowed one in the code.
+ sendToStatusInternal
+ setStatusInternal
+ statusEquals Use to check the current value of status of the model.