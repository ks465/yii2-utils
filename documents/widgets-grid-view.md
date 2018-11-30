#GridView Class
GridView 1.* and AjaxGridView 1.* are merged together, and there is no AjaxGridView in the 2.* version.
In order to reach AJAX activity, use [[\khans\utils\columns\ActionColumn|ActionColumn]] and set `runAsAjax = true,` for
individual button or for all the column. 

```php
$firstRow = [
    [
        'content' => '',
        'options' => [
            'class' => 'skip-export', // remove this column from export
        ],
    ],
    [
        'content' => 'Group 1',
        'options' => [
            'colspan' => 2,
            'class' => 'text-center',
        ],
    ],
    [
        'content' => 'Group 2',
        'options' => [
            'colspan' => 4,
            'class' => 'text-center',
        ],
    ],
    [
        'content' => 'Group 3',
        'options' => [
            'colspan' => 4,
            'class' => 'text-center',
        ],
    ],
    [
        'content' => 'Group 4',
        'options' => [
            'colspan' => 4,
            'class' => 'text-center',
        ],
    ],
];

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
    ],
    [
        'class' => 'khans\utils\columns\RadioColumn',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
    ],
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'runAsAjax'      => true,
        'dropdownButton' => ['class' => 'btn btn-default alert-success', 'label' => 'GoOn'],
        'header'         => 'Extra Actions',
        'visibleButtons' => [
            'view'     => false,
            'update'   => false,
            'delete'   => false,
            'download' => false,
            'audit'    => true,
        ],
        'extraItems'     => $this->buildExtras(),
    ],
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'audit'          => true,
        'runAsAjax'      => false,
        'viewOptions'    => [
            'runAsAjax' => true,
        ],
        'download'       => Url::to(['/my-action', 'id' => 124]),
        'dropdownButton' => ['class' => 'btn btn-danger'],
    ],
];

echo GridView::widget([
    'id' => 'data-table',
    'type' => 'success',
    'title' => 'Title of the data grid',
    'footer' => 'Notification go to footer of the table',
    'before' => 'Link or Text before the data rows',
    'after' => 'Link or Text after the data rows',
    'content' => 'Some Link or Some Warning',
    'showRefreshButtons' => false,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showPageSummary' => true,
    'columns' => $columns,
    'beforeHeader' => [
        [
            'columns' => $firstRow,
            'options' => ['class' => 'skip-export'] // remove this row from export
        ],
    ],
    'bulkAction' => [
        'action'  => 'some-action',
        'label'   => 'Do Somthing',
        'icon'    => 'send',
        'class'   => '',
        'message' => '',
    ],
]);
```
Adding extra actions to the column definition of the grid is very similar to the usage of bulk action with [[RadioColumn]].
Setting footer to `false` removes the pager segment too.
Add `skip-export` to options.class of virtually any row or column to remove it from export.
Default `title` of the grid is View::title of the page.
