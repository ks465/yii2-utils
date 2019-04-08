#Persian Setup
Documentation Edition: 1.2-980119

Set following in the common main `config` file:

```php
'language' => 'fa-IR',
'timeZone' => 'Asia/Tehran',
'on beforeRequest' => [
    '\khans\utils\components\StringHelper',
    'screenInput',
],
```

Check the main `layout` file for the following:

```html
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="author" content="Keyhan Sedaghat">
    <meta name="author" content="mailto:keyhansedaghat@netscape.net">
    <meta charset="<?= Yii::$app->charset ?>">
...
```

Add following files from `@khan/helpers/assets/css` to the appropriate place (usually `web/css` in each application).

Use one of these font families in the `site.css`.
```text
IRANSansWebFaNum.woff
IRANSansWebFaNum_Bold.woff
IRANSansWebFaNum_Light.woff
IRANSansWebFaNum_Medium.woff
IRANSansWebFaNum_UltraLight.woff
```

* persian-site.css
This is probably a MUST.
```css
@font-face {
    font-family: "parsi";
    src: url('IRANSansWebFaNum_UltraLight.woff') format('woff2');
}

* {
    font-family: parsi;
}

html, body, input, .rtl {
    direction: rtl;
    color: #0e7f08;
    background-color: #fffff2;
}

.pars-wrap {
    overflow: auto;
    word-wrap: break-word;
    white-space: pre-wrap !important;
}

.close {
    float: left;
}

a.goToday {
    margin: -20px;
    position: fixed;
}

#spinner-frame {
    z-index: 10000;
}

.dropdown-menu {
    text-align: right;
}

.dropdown-submenu > a:before {
    content: '◄';
    float: left;
}

.dropdown-submenu > a:after {
    display: none !important;
}

.dropdown-submenu > .dropdown-menu {
    border-radius: 6px 0 6px 6px !important;
    left: auto !important;
    top: auto !important;
    right: calc(100% - 5px);
}
```

* customized.css
This is not a MUST
```css
.nav-select-list .table{
    height: 350px;
    overflow-y: scroll;
}

#watermark {
    color: #d0d0d0;
    font-size: 200pt;
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    z-index: -1;
    left:-100px;
    top:-200px;
}

.form-horizontal .control-label {
    float: right;
}

.select2-container .select2-selection__rendered {
    width: 0 !important;
    min-width: 100% !important;
}

table.kv-child-table {
    width: 100%;
}

.navbar-brand {
    padding: 0 !important;
}

.checkbox label, .radio label {
    padding-right: 20px;
}

.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
    position: absolute;
    margin-right: -20px;
}

.x-dropdown .checkbox {
    margin-right: 15px;
    padding-left: 2px;
}

.x-dropdown input {
    margin-right: -25px;
    margin-top: 0;
}

.r-dropdown {
    left: auto !important;
}

.nav-select-list .table{
    height: 350px;
    overflow-y: scroll;
}
```