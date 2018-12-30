#ExportMenu
This widget extends [[\kartik\export\ExportMenu]] and is used for some provisions about behavior in rendering --
specially for RTL aspects-- and some preset messages. All the required configuration is `dataProvider` only:

This widget could be added to a [[\khans\utils\widgets\GridView]] by setting [[\khans\utils\widgets\GridView::export]] equal to [[\khans\utils\widgets\GridView::EXPORTER_MENU]] 

```php
$exporter = ExportMenu::widget([
    'dataProvider' => $this->dataProvider,
]);
```
The default values for the widget are as the following:

```php
$exporter = ExportMenu::widget([
    'dataProvider'              => $grid->dataProvider, // this is mandatory to set
    'target'                    => ExportMenu::TARGET_SELF,
    'showConfirmAlert'          => true, // this assures that the menu is closed after selecting the format.
    'clearBuffers'              => true,
    'initProvider'              => true,
    'fontAwesome'               => true,
    'template'                  => "{menu}\n{columns}", // more sense in RTL views
    'exportConfig'              => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
    ],
    'messages'                  => [
            'allowPopups'      => 'بسته به داده‌ها و صفحه انتخاب شده، شاید این کار زمان نیاز داشته باشد.',
            'confirmDownload'  => 'تهیه فایل درخواستی آغاز شود؟',
            'downloadProgress' => 'در حال ساخت فایل',
            'downloadComplete' => 'فایل آماده دریافت اس.',
    ],
    'docProperties'             => [
        'title'    => 'مرکز آمار و داده‌پردازی',
        'subject'  => 'کیهان صداقت' . ' ' . 'keyhansedaghat@netscape.net'm
        'keywords' => 'AUT, KHanS',
        'company'  => 'KHanS.org',
        ... // other parts are intact
    ],
    'columnSelectorOptions'     => [
        'class' => 'btn-info',
        ... // other parts are intact
    ],
    'dropdownOptions'           => [
        'class'       => 'btn-info',
        'menuOptions' => [
            'class' => 'dropdown-menu-right', 
            'style' => 'z-index: 123456;',
        ],
        ... // other parts are intact
    ],
    'columnSelectorMenuOptions' => [
        'class' => 'dropdown-menu-right',
        'style' => 'z-index: 123456;',
        ... // other parts are intact
    ],
]);
```
Exportable formats include from this widget are:
  - `CSV`
  - `PDF`
  - `Excel-95`
  - `Excel-2007`
  - `HTML` is disabled
  - `Text` is disabled
