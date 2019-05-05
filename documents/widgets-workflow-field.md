#WorkflowField Class
Documentation Edition: 1.0-980212
Class Version: 0.2.0-971021

```php
<?= $form->field($model, 'workflow_status')->widget(\khans\utils\widgets\WorkflowField::class, []) ?>
```
This will show a Select2 widget with all of statuses in the workflow of the `$model` as the options for select.