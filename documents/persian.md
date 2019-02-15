#Persian Setup
Documentation Edition: 1.1-971112

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

```text
site.css
custom.css

IRANSansWebFaNum.woff
IRANSansWebFaNum_Bold.woff
IRANSansWebFaNum_Light.woff
IRANSansWebFaNum_Medium.woff
IRANSansWebFaNum_UltraLight.woff
```
