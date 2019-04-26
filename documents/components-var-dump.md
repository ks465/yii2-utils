#VarDump Class
Documentation Edition: 1.1-980206
Class Version: 0.3.3-980206

This is a third party class offering dumping variables with ability to expand or hide parts of data. 
In this way it can keep the display clear.
The original class has multiple themes included, which are named after comic strip heroes. 
The names are changed to color names.
  
_**Because this is a third party class, there is no unit test for this class.** For examples see the demo section._

_**There is no need to call methods in this class directly. Just use `vd` or `vdd` as following examples show.**_

1. `vd` Dump one _or more_ variables and continue execution.
1. `vdd` Dump one *or more* variables. This method will stop your script after the dump.  

**_Important Notice:
You should require the containing class early in your scripts, in order to activate these shortcuts._** 
Although you can just add it on the point of usage.
Add the following segment to seb config AND console config:

```php
if (YII_ENV_DEV) { //add YII_DEBUG if you want to debug production applications 
    require_once (__DIR__ . '/../vendor/khans465/yii2-utils/src/components/VarDump.php');
}
```

Examples:

```php
//Suppose this is on the 17th line of file `/var/www/html/khans/views/site/index.php`
vd(Yii::$app->user); 
```

Results the following output:

```text
/var/www/html/khans/views/site/index.php:17
[expand all] [reduce all]
array(6) [...] [expand]
```
First line is the filename and line number of the calling the functions.
Second line has two clickable links for expanding/reducing all the data.
Third line starts the dump. The `expand` link shows the first level of the data:

```php
/var/www/html/khans/views/site/index.php:17
[expand all] [reduce all]
array(6) [...] [reduce]
    string(19) "Yii::$app->user->id" => null
    string(15) "Yii::$app->user" => yii\web\User#0 {...} [expand]
    string(26) "Yii::$app->getComponents()" => array(15) [...] [expand]
    string(29) "\yii\helpers\Url::to('@khan')" => string(46) "/var/www/html/khans/vendor/khans465/yii2-utils/src"
    string(22) "Yii::getAlias('@khan')" => string(46) "/var/www/html/khans/vendor/khans465/yii2-utils/src"
    string(11) "Just saying" => array(3) [...] [expand]
``` 

Each `expand` and `reduce` link is used to show or hide one part of the dump, one level each time.

1. `explain` Dumps a Query using [SqlFormatter](components-sql-formatter.md).
It can distinguish between Query and [RestQuery](compoents-rest-v1.md) variants.
1. `xd` Dumps the query string and exit the code. 