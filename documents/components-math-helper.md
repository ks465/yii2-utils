#MathHelper Class
This class contains methods to do some mathematical routines easier.

##floorBy()
This method similar to the library floor() function, round fractions down. But instead of fractions of whole number
(=1), It accepts a stepping number which defaults to 0.5. Using the `$step = 1` results are the same as PHP::floor().

```php
echo MathHelper::floorBy(-1.00); //-1.0
echo MathHelper::floorBy(-0.90); //-1.0
echo MathHelper::floorBy(-0.50); //-0.5
echo MathHelper::floorBy(-0.35); //-0.5
echo MathHelper::floorBy(-0.01); //-0.5
echo MathHelper::floorBy(0.00)); //0.0
echo MathHelper::floorBy(0.05)); //0.0
echo MathHelper::floorBy(0.45)); //0.0
echo MathHelper::floorBy(0.50)); //0.5
echo MathHelper::floorBy(0.55)); //0.5
echo MathHelper::floorBy(0.95)); //0.5
echo MathHelper::floorBy(1.00)); //1.0
echo MathHelper::floorBy(1.45)); //1.0
echo MathHelper::floorBy(1.50)); //1.5
echo MathHelper::floorBy(15.40); //15.0

$step = 0.2;
echo MathHelper::floorBy(-1.00, $step); //-1.0
echo MathHelper::floorBy(-0.90, $step); //-1.0
echo MathHelper::floorBy(-0.50, $step); //-0.6
echo MathHelper::floorBy(-0.35, $step); //-0.4
echo MathHelper::floorBy(-0.01, $step); //-0.2
echo MathHelper::floorBy(0.00, $step); //0.0
echo MathHelper::floorBy(0.05, $step); //0.0
echo MathHelper::floorBy(0.45, $step); //0.4
echo MathHelper::floorBy(0.50, $step); //0.4
echo MathHelper::floorBy(0.55, $step); //0.4
echo MathHelper::floorBy(0.95, $step); //0.8
echo MathHelper::floorBy(1.00, $step); //1.0
echo MathHelper::floorBy(1.45, $step); //1.4
echo MathHelper::floorBy(1.50, $step); //1.4
echo MathHelper::floorBy(15.40, $step); //15.4

$step = 0.75;
echo MathHelper::floorBy(-1.00, $step); //-1.5
echo MathHelper::floorBy(-0.90, $step); //-1.5
echo MathHelper::floorBy(-0.50, $step); //-0.75
echo MathHelper::floorBy(-0.35, $step); //-0.75
echo MathHelper::floorBy(-0.01, $step); //-0.75
echo MathHelper::floorBy(0.00, $step); //0.0
echo MathHelper::floorBy(0.05, $step); //0.0
echo MathHelper::floorBy(0.45, $step); //0.0
echo MathHelper::floorBy(0.50, $step); //0.0
echo MathHelper::floorBy(0.55, $step); //0.0
echo MathHelper::floorBy(0.95, $step); //0.75
echo MathHelper::floorBy(1.00, $step); //0.75
echo MathHelper::floorBy(1.45, $step); //0.75
echo MathHelper::floorBy(1.50, $step); //1.5
echo MathHelper::floorBy(15.40, $step); //15.0

$step = 1.0;
echo MathHelper::floorBy(-1.00, $step); //-1.0
echo MathHelper::floorBy(-0.90, $step); //-1.0
echo MathHelper::floorBy(-0.50, $step); //-1.0
echo MathHelper::floorBy(-0.35, $step); //-1.0
echo MathHelper::floorBy(-0.01, $step); //-1.0
echo MathHelper::floorBy(0.00, $step); //0.0
echo MathHelper::floorBy(0.05, $step); //0.0
echo MathHelper::floorBy(0.45, $step); //0.0
echo MathHelper::floorBy(0.50, $step); //0.0
echo MathHelper::floorBy(0.55, $step); //0.0
echo MathHelper::floorBy(0.95, $step); //0.0
echo MathHelper::floorBy(1.00, $step); //1.0
echo MathHelper::floorBy(1.45, $step); //1.0
echo MathHelper::floorBy(1.50, $step); //1.0
echo MathHelper::floorBy(15.40, $step)); //15.0

$step = 1.3;
echo MathHelper::floorBy(-1.00, $step); //-1.3
echo MathHelper::floorBy(-0.90, $step); //-1.3
echo MathHelper::floorBy(-0.50, $step); //-1.3
echo MathHelper::floorBy(-0.35, $step); //-1.3
echo MathHelper::floorBy(-0.01, $step); //-1.3
echo MathHelper::floorBy(0.00, $step); //0.0
echo MathHelper::floorBy(0.05, $step); //0.0
echo MathHelper::floorBy(0.45, $step); //0.0
echo MathHelper::floorBy(0.50, $step); //0.0
echo MathHelper::floorBy(0.55, $step); //0.0
echo MathHelper::floorBy(0.95, $step); //0.0
echo MathHelper::floorBy(1.00, $step); //0.0
echo MathHelper::floorBy(1.45, $step); //1.3
echo MathHelper::floorBy(1.50, $step); //1.3
echo MathHelper::floorBy(15.40, $step); //14.3
```

##ceilBy()
This method similar to the library ceil() function, round fractions up. But instead of fractions of whole number
(=1), It accepts a stepping number which defaults to 0.5. Using the `$step = 1` results are the same as PHP::ceil().   

```php
echo MathHelper::ceilBy(-1.00); //-1.0
echo MathHelper::ceilBy(-0.90); //-0.5
echo MathHelper::ceilBy(-0.50); //-0.5
echo MathHelper::ceilBy(-0.35); //-0.0
echo MathHelper::ceilBy(-0.01); //-0.0
echo MathHelper::ceilBy(0.00); //0.0
echo MathHelper::ceilBy(0.05); //0.5
echo MathHelper::ceilBy(0.45); //0.5
echo MathHelper::ceilBy(0.50); //0.5
echo MathHelper::ceilBy(0.55); //1.0
echo MathHelper::ceilBy(0.95); //1.0
echo MathHelper::ceilBy(1.00); //1.0
echo MathHelper::ceilBy(1.45); //1.5
echo MathHelper::ceilBy(1.50); //1.5
echo MathHelper::ceilBy(15.40); //15.5

$step = 0.2;
echo MathHelper::ceilBy(-1.00, $step); //-1.0
echo MathHelper::ceilBy(-0.90, $step); //-0.8
echo MathHelper::ceilBy(-0.50, $step); //-0.4
echo MathHelper::ceilBy(-0.35, $step); //-0.2
echo MathHelper::ceilBy(-0.01, $step); //0.0
echo MathHelper::ceilBy(0.00, $step); //0.0
echo MathHelper::ceilBy(0.05, $step); //0.2
echo MathHelper::ceilBy(0.45, $step); //0.6
echo MathHelper::ceilBy(0.50, $step); //0.6
echo MathHelper::ceilBy(0.55, $step); //0.6
echo MathHelper::ceilBy(0.95, $step); //1.0
echo MathHelper::ceilBy(1.00, $step); //1.0
echo MathHelper::ceilBy(1.45, $step); //1.6
echo MathHelper::ceilBy(1.50, $step); //1.6
echo MathHelper::ceilBy(15.40, $step); //15.4

$step = 0.75;
echo MathHelper::ceilBy(-1.00, $step); //-0.75
echo MathHelper::ceilBy(-0.90, $step); //-0.75
echo MathHelper::ceilBy(-0.50, $step); //0.0
echo MathHelper::ceilBy(-0.35, $step); //0.0
echo MathHelper::ceilBy(-0.01, $step); //0.0
echo MathHelper::ceilBy(0.00, $step); //0.0
echo MathHelper::ceilBy(0.05, $step); //0.75
echo MathHelper::ceilBy(0.45, $step); //0.75
echo MathHelper::ceilBy(0.50, $step); //0.75
echo MathHelper::ceilBy(0.55, $step); //0.75
echo MathHelper::ceilBy(0.95, $step); //1.5
echo MathHelper::ceilBy(1.00, $step); //1.5
echo MathHelper::ceilBy(1.45, $step); //1.5
echo MathHelper::ceilBy(1.50, $step); //1.5
echo MathHelper::ceilBy(15.40, $step); //15.75

$step = 1.0;
echo MathHelper::ceilBy(-1.00, $step); //-1.0
echo MathHelper::ceilBy(-0.90, $step); //0.0
echo MathHelper::ceilBy(-0.50, $step); //0.0
echo MathHelper::ceilBy(-0.35, $step); //0.0
echo MathHelper::ceilBy(-0.01, $step); //0.0
echo MathHelper::ceilBy(0.00, $step); //0.0
echo MathHelper::ceilBy(0.05, $step); //1.0
echo MathHelper::ceilBy(0.45, $step); //1.0
echo MathHelper::ceilBy(0.50, $step); //1.0
echo MathHelper::ceilBy(0.55, $step); //1.0
echo MathHelper::ceilBy(0.95, $step); //1.0
echo MathHelper::ceilBy(1.00, $step); //1.0
echo MathHelper::ceilBy(1.45, $step); //2.0
echo MathHelper::ceilBy(1.50, $step); //2.0
echo MathHelper::ceilBy(15.40, $step); //16.0

$step = 1.3;
echo MathHelper::ceilBy(-1.00, $step); //0.0
echo MathHelper::ceilBy(-0.90, $step); //0.0
echo MathHelper::ceilBy(-0.50, $step); //0.0
echo MathHelper::ceilBy(-0.35, $step); //0.0
echo MathHelper::ceilBy(-0.01, $step); //0.0
echo MathHelper::ceilBy(0.00, $step); //0.0
echo MathHelper::ceilBy(0.05, $step); //1.3
echo MathHelper::ceilBy(0.45, $step); //1.3
echo MathHelper::ceilBy(0.50, $step); //1.3
echo MathHelper::ceilBy(0.55, $step); //1.3
echo MathHelper::ceilBy(0.95, $step); //1.3
echo MathHelper::ceilBy(1.00, $step); //1.3
echo MathHelper::ceilBy(1.45, $step); //2.6
echo MathHelper::ceilBy(1.50, $step); //2.6
echo MathHelper::ceilBy(15.40, $step); //15.6
```