#WorkflowBehavior Class
Documentation Edition: 1.0-980202
Class Version: 0.1.0-971021


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
readStatusesFromTable
getStatusesLabels
getWorkflowState


These are inherited methods:
afterDelete
afterSaveStatus
attach
beforeDelete
beforeSaveStatus
createTransitionItems
doAutoInsert
ensureStatusInstance
enterWorkflow
events
firePendingEvents
getDefaultWorkflowId
getEventSequence
getNextStatuses
getOwnerStatus
getScenarioSequence
getStatusAccessor
getStatusConverter
getWorkflow
getWorkflowSource
getWorkflowStatus
hasWorkflowStatus
init
initStatus
isAttachedTo
selectDefaultWorkflowId
sendToStatus
sendToStatusInternal
setStatusInternal
statusEquals