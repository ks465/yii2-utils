#GridView Class
Documentation Edition: 1.1-971112
Class Version: 2.3.5-971111

GridView 1.* and AjaxGridView 1.* are merged together, and there is no AjaxGridView in the 2.* version.
In order to reach AJAX activity, use [[\khans\utils\columns\ActionColumn|ActionColumn]] and set `runAsAjax = true,` for
individual button or for all the column. 
Required assets for modal pages are handled through [[GridAsset]] class.

`pagination.pageParam` and `sort.sortParam` attribute of the `dataProvider` are set according to the `id` of the widget.
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

$buildExtras = [
   'name'   => [
       'icon'   => 'edit',
       'action' => 'otherAction',
       'config' => ['class' => 'alert-danger text-success'],
   ],
   [],
   'rename' => [
       'title'  => 'Test Me',
       'icon'   => 'pencil',
       'config' => ['class' => 'alert-success text-success'],
   ],
   'reset'  => [
       'runAsAjax' => false,
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
            'history'    => true,
        ],
        'extraItems'     => $buildExtras,
    ],
    [
        'class'          => 'khans\utils\columns\ActionColumn',
        'history'          => true,
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
        'hint'    => 'با همه انتخاب شده‌ها',
    ],
    'createAction' => [
         'action' => 'create',
         'title'  => 'افزودن',
         'icon'   => 'plus',
         'class'  => 'btn btn-success btn-xs',
         'ajax'   => true,
     ],
]);
```

- By setting `panel => false`, panel heading, before and after are removed from output.

Adding extra actions to the column definition of the grid is very similar to the usage of bulk action with [[RadioColumn]].
Setting footer to `false` removes the pager segment too.
Add `skip-export` to options.class of virtually any row or column to remove it from export.
Default `title` of the grid is View::title of the page.

createAction can be
 + _true_: Show a create button in the toolbar content with default configuration.
 + _false_: Remove the button completely.
 + _array_: [
 
        'action' => 'create', //target action
        'title'  => 'افزودن', //tooltip text of the button
        'icon'   => 'plus', //glyphicon tag
        'class'  => 'btn btn-success btn-xs', //class of shown link
        'ajax'   => true, //true adds `role => modal-remote` will be set in button options.
                          //false makes `role => ''`.

###showRefreshButtons
Setting this parameter to `true` enables two buttons in the panel. Both of them refresh the grid view,
But one of them keeps all the query parameters (in other words all the pagination and filters).
The other only keeps the action parameters, hence destroys the filters. By keeping action parameters,
grid views in parent-child views behave as stand alone grids.

###BulkAction
+ Set as array. In this scenario one action is available to take act upon the selection in the grid. The submit method is AJAX.
```php
'bulkAction' => [
        'action'  => 'some-action',
        'label'   => 'Do Somthing',
        'icon'    => 'send',
        'class'   => '',
        'message' => '',
        'hint'    => 'با همه انتخاب شده‌ها',
    ],
```
+ Set as DropDown. In this scenario multiple actions are available to take act upon the selection in the grid.
In this case the submit method is also AJAX. See [DropdownX](widgets-dropdown.md) for details.
```php
'bulkAction' => [
    'action'  =>khans\utils\widgets\DropdownX::widget([
        'items' => [
            [
                'label' => 'دریافت داده‌های صفحه',
            ],
            [
                'label'   => 'دستور یک',
                'url'     => 'index',
                'message' => 'پیام شماره یک',
            ],
            [
                'label' => 'دستورات',
                'class' => 'danger',
                'items' => [
                    [
                        'label'   => 'دستور ۲',
                        'message' => 'پیام شماره ۲',
                    ],
                    [
                        'label'   => 'دستور سه',
                        'url'     => 'about',
                        'message' => 'پیام شماره سه',
                        'class'   => 'danger',
                    ],
                    [
                        'label'   => 'باز هم دستور',
                        'message' => 'پیام شماره چهار',
                        'url'     => 'login',
                    ],
                ],
            ],
            [
                'label'   => 'باز هم یک دستور دیگر',
                'url'     => '#',
                'message' => 'پیام شماره پنج',
            ],
            '<li class="divider"></li>',
            [
                'label' => 'دستور جدا شده',
                'url'   => '#',
                'class' => 'success',
            ],
        ]
        ]),
    'label' => 'Do Something',
    'icon' => 'send',
    'class'   => '',
    'message' => '',
    'hint'    => 'با همه انتخاب شده‌ها',
]
```

###Export
In this widget value of `export` could be one of these:
+ `false` or `null`: In this case no export button is rendered. This is the default.
+ `true` or `GridView::EXPORTER_SIMPLE`: In this case default export button for GridView widget is used.
Note that in this case only the active page is exported. The exportable formats are `PDF` and `CSV` only.
+ `GridView::EXPORTER_MENU`: In this case the [[\khans\utils\widgets\ExportMenu]] is used. 
In this case the exported columns are selectable. All the records are exported. Exportable formats include:
  - `CSV`
  - `PDF`
  - `Excel-95`
  - `Excel-2007`
  - `HTML` is disabled
  - `Text` is disabled
+ Prepared value: You may build a [[\khans\utils\widgets\ExportMenu]] and set the `export` value to it. 
In this case all is yours, and nothing could be said.

In the built-in types the data filters in the grid are respected and are used for exporting.
