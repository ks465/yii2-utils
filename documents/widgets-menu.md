#OverlayMenu Class
Documentation Edition: 1.1-971112
Class Version: 0.1.0-970717

This is a simple widget class to render the menu. It consists of: 
+ OverlayMenuFiller
+ OverlayMenuAsset
+ views/menu

```php
echo OverlayMenu::widget([
    'title'      => 'General Menu',
    'label'      => 'This Is the Output',
    'tag'        => 'button',
    'csvFileUrl' => '@khan/tests/demos/sample-menu.csv',
    'options'    => ['class' => 'btn btn-danger'],
    'tabs'       => [
        'general'    => [
            'id'    => 'general',
            'title' => 'General',
            'icon'  => 'heart',
            'admin' => false,
        ],
        'others'     => [
            'id'    => 'others',
            'title' => 'Others',
            'icon'  => 'user',
            'admin' => false,
        ],
        'management' => [
            'id'    => 'management',
            'title' => 'Manager',
            'icon'  => 'alert',
            'admin' => true,
        ],
    ],
]);
```

The above code renders a button on the page to activate the overlay menu.
By rendering the widget, a button is placed on the page. You can render the button in the `NavBar`.
The `tabs` section is optional. The [[\khans\utils\widgets\menu\OverlayFiller]] creates it if omitted.

##subsection
put generic images in package as default.

create a CRUD for the csv content.

use cache for holding the menu items.

##OverlayMenuFiller
This is the part which builds the data array, which later is rendered in the views/menu.
It is not necessary to build the filler separately. You can configure the main class.

##OverlayMenuAsset
This an AssetBundle class which publishes the required CSS and JS files to the web root.

##CSV structure
Current implementation requires the following fields to be present in the CSV file. 
1. id Primary key of the data
1. title String to place in the link.
1. url Target of the menu link.
1. image Icon for each item. --NOT in use currently
1. class Display class for texts.
1. tab Id of the section --also column-- of the menu.
1. order Sorting number.
