#MathHelper Class
This class contains methods to do some mathematical routines easier.

##floorBy()
This method similar to the library floor() function, round fractions down. But instead of fractions of whole number
(=1), It accepts a stepping number which defaults to 0.5. Using the `$step = 1` results are the same as PHP::floor().

```php
echo MathHelper::floorBy(-1.00); //-1.0
echo MathHelper::floorBy(0.00)); //0.0
echo MathHelper::floorBy(0.50)); //0.5
echo MathHelper::floorBy(0.95)); //0.5

$step = 0.2;
echo MathHelper::floorBy(-1.00, $step); //-1.0
echo MathHelper::floorBy(1.50, $step); //1.4

$step = 0.75;
echo MathHelper::floorBy(-1.00, $step); //-1.5
echo MathHelper::floorBy(1.50, $step); //1.5

$step = 1.0;
echo MathHelper::floorBy(-1.00, $step); //-1.0
echo MathHelper::floorBy(1.50, $step); //1.0
echo MathHelper::floorBy(15.40, $step)); //15.0

$step = 1.3;
echo MathHelper::floorBy(-1.00, $step); //-1.3
echo MathHelper::floorBy(0.00, $step); //0.0
echo MathHelper::floorBy(1.50, $step); //1.3
echo MathHelper::floorBy(15.40, $step); //14.3
```

##ceilBy()
This method similar to the library ceil() function, round fractions up. But instead of fractions of whole number
(=1), It accepts a stepping number which defaults to 0.5. Using the `$step = 1` results are the same as PHP::ceil().   

```php
echo MathHelper::ceilBy(-1.00); //-1.0
echo MathHelper::ceilBy(1.45); //1.5

$step = 0.2;
echo MathHelper::ceilBy(-1.00, $step); //-1.0
echo MathHelper::ceilBy(1.50, $step); //1.6
echo MathHelper::ceilBy(15.40, $step); //15.4

$step = 0.75;
echo MathHelper::ceilBy(-1.00, $step); //-0.75
echo MathHelper::ceilBy(1.50, $step); //1.5
echo MathHelper::ceilBy(15.40, $step); //15.75

$step = 1.0;
echo MathHelper::ceilBy(-1.00, $step); //-1.0
echo MathHelper::ceilBy(1.50, $step); //2.0
echo MathHelper::ceilBy(15.40, $step); //16.0

$step = 1.3;
echo MathHelper::ceilBy(-1.00, $step); //0.0
echo MathHelper::ceilBy(1.50, $step); //2.6
echo MathHelper::ceilBy(15.40, $step); //15.6
```

##numberToWord
This method converts given number from digital presentation to textual presentation.

```php
echo MathHelper::numberToWord(-690); //منهای ششصد و نود
echo MathHelper::numberToWord(100001); //یکصد هزار و یک
echo MathHelper::numberToWord(3.936); //سه ممیز نهصد و سی و شش هزارم
```
