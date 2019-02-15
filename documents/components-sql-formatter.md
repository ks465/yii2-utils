#SqlFormatter Class
Documentation Edition: 1.0-960420
Class Version: 0.1.1-960420

This class is a third party Object. It is capable of producing well formatted SQL statements with coloring.
The coloring is available in CLI and web. There is no need to do anything special to recognize the environment.
Obviously if the CLI environment is not capable of highlighting, the output is in plain normal text. But there is no
error or problem.

_**Because this is a third party class, there is no unit test for this class.** For examples see the demo section._

_**There is no need to call methods in this class directly. Just use `explain` or `xd` as following examples show.**_

1. `explain` Show a formatted text of an SQL query.
1. `xd` Show a formatted text of an SQL query. This method will stop your script after the dump.

**_Important Notice:
You should require the containing class early in your scripts, in order to activate these shortcuts._**

```php
require_once \Yii::getAlias('@khan/components/VarDump.php');
```

Examples:


```php
$sql = KHanModel::find()
    ->andWhere(['i' => 1])
    ->groupBy(['x'])
    ->having(['>', 'z', 1])
    ->orderBy(['alpha' => SORT_ASC])
    ->createCommand()->rawSql;

echo($sql); //This result in no coloring in CLI or web:
//SELECT * FROM `khan_model` WHERE `i`=1 GROUP BY `x` HAVING `z` > 1 ORDER BY `alpha`

echo SqlFormatter::format($sql); //The output is highlighted in both web and CLI.
/*
SELECT 
  * 
FROM 
  `khan_model` 
WHERE 
  `i` = 1 
GROUP BY 
  `x` 
HAVING 
  `z` > 1 
ORDER BY 
  `alpha`
 */
```

For simplicity you can use `explain` or `xp` for this purpose:

```php
explain($sql); //shows the calling file name and line. Then continue the script.

/*
path/to/calling/file:lineNumber

SELECT 
  * 
FROM 
  `khan_model` 
WHERE 
  `i` = 1 
GROUP BY 
  `x` 
HAVING 
  `z` > 1 
ORDER BY 
  `alpha`
 */
xd($sql); //this has the same output. But stops the script afterward.
```
