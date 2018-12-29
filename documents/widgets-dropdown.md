#KHDropDown
This is a helper class to build a [kartik\dropdown\DropdownX] with modal actions, searching for selections in a grid.
It would not work without input elements of type radio and checkbox.
Besides these elements should be named `selection`.
This case is default when defining a [khans\utils\widgets\GridView] and add [khans\utils\columns], [\kartik\grid\RadioColumn], or [kartik\grid\CheckboxColumn]. So, in reality, [KHDropdown] is used instead of GridView::bulkAction['action'].

This widget has only one configuration item: an array named `items`.
Each element of this array is either:
+ An array with a single item `label', which would be shown as a header for the next segment(s).
+ A string of exact form of `'<li class="divider"></li>',`, which would be shown as a divider line.
+ An array containing following items:
  - `label` text to show as menu item,
  - `url` action of the menu,
  - `message` warning meesage in the confirmation box,
  - `class` any of the `info`, `success`, `primary`, `warning`, or `danger`. Default is `default`.
+ An array containing `items` key, which has the exact structure of the parent, and will serve as a submenu.
```php
$config['bulkAction'] = KHDropdown::widget([
    'items' => [
        [
            'label' => 'عنوان منوی اصلی',
        ],
        [
            'label'   => 'دستور یک',
            'url'     => 'index',
            'message' => 'پیام شماره یک',
        ],
        [
            'label'   => 'باز هم یک دستور دیگر',
            'url'     => '#',
            'message' => 'پیام شماره پنج',
        ],
        '<li class="divider"></li>',
        [
            'label' => 'کلید زیرمنوی یکم',
            'class' => 'danger',
            'items' => [
                [
                    'label'   => 'عنوان زیرمنوی یکم',
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
        '<li class="divider"></li>',
        [
            'label' => 'عنوان منوی فرعی',
        ],
        [
            'label' => 'دستور جدا شده',
            'url'   => '#',
            'class' => 'success',
        ],
    ],
]);
```

If there is no selection found, there would be a warning and nothing is happened. If there is one or more selections found, a warning message is shown about the command and upon confirming, the action is called.
