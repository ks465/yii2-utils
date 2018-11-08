#SqlFormatter Class
This class is a third party Object. It is capable of producing well formatted SQL statements with coloring.
The coloring is available in CLI and web. There is no need to do anything special to recognize the environment.
Obviously if the CLI environment is not capable of highlighting, the output is in plain normal text. But there is no
error or problem.

_**Because this is a third party class, there is no unit test for this class.** For examples see the demo section._


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

