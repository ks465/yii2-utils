#Loading Spinner
Documentation Edition: 1.0-980305
Class Version: 0.1.0-941105

An animation which is activated on each page loading.
To setup do the following:

+ Add the `helpers/assets/js/spinner.js` to application webroot (usually @web/js),
+ Add the resource to the Asset Manager (usually `app\assets\AppAsset`):

```php
public $css = [
	'css/site.css',
	'css/custom.css',
];
public $js = [
    'js/spinner.js'
];
```

This is also ture for using the customized CSS settings.

+ Add the Spinner assets to the main layout file (usually @app/views/layouts/main.php):

```php
use kartik\spinner\SpinnerAsset;
SpinnerAsset::register($this); 
```

+ Add the required html elements right at top of the page:

```html
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div id="spinner-frame" style="position: fixed; margin-top: 250px; width: 100%;">
            <div id="spinner-span" style="width: 10%;" class="center-block text-center"></div>
        </div>
	...
```