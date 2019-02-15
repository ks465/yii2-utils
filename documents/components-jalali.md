#Jalali and JalaliX Classes
Documentation Edition: 1.0-970820
Class Version: 3.2.4-970816

Jalali class is an attempt to use astronomical calculations of Khayyam and keep the interface 
as similar as possible to `PHP::date()` function.

Jalali has two main public methods:
1. `Jalali::date()` which by accepting format and timestamp returns a date string.

1. `Jalali::mktime()` which accepts elements of date and time and returns timestamp integer.
 
1. Other public methods, show output based on the last static usage of any of the above methods:
   + `date()` This is a clone of the internal php function date(). 
   + `dayName()` Returns names of the weekday in full 
   + `dayOfWeek()` Get number of days from starting of the current week 
   + `dayOfYear()` Get value of the day in the year 
   + `dayShortName()` Returns abbreviated --single letter-- names of the weekday. 
   + `getDay()` Get day in month value 
   + `getHour()` Get hour 
   + `getMinute()` Get minute 
   + `getMonth()` Get month value 
   + `getSecond()` Get second 
   + `getTimestamp()` Get current value of the timestamp in Unix timestamp format 
   + `getWeekName()` Return number of week from beginning of the month in words 
   + `getYear()` Get year value 
   + `isLeap()` Checks the specified year for a leap year. 
   + `monthDayString()` Returns long text day of the month 
   + `monthName()` Returns names of the month 
   + `monthShortName()` Returns abbreviated --three-letters-- names of the month 
   + `weekOfYear()`  Get value of week number in year 

```php
try {
    $j = new Jalali();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
//Class khans\utils\components\Jalali should not be instantiated. Use static methods only.

echo Jalali::date('Y/m/d H:i:s');
//1397/08/17 08:40:03

echo Jalali::date('Y/m/d H:i:s', time());
//1397/08/17 08:40:03

echo Jalali::date('Y/m/d H:i:s', time(), true);
//۱۳۹۷/۰۸/۱۷ ۰۸:۴۵:۳۳

echo Jalali::getYear();
//1397

echo Jalali::timestamp();
//1541653803

echo Jalali::getMinute();
//40

echo Jalali::getDoW();
//6

echo Jalali::date('o', $time);
//1397

echo Jalali::date('t', $time);
//30

echo Jalali::date('u', $time);
//000000

echo Jalali::date(Jalali::KHAN_SHORT, $time);
//1397/08/17 08:48:25

echo Jalali::date(Jalali::KHAN_LONG, $time);
//پنج شنبه هفدهم آبان 1397، 08 و 52 دقیقه

echo Jalali::date(Jalali::KHAN_FILENAME, $time);
//1397_08_17-08_48
```

`JalaliX` tries to fulfills other requirements in a date object. 
Most important aspect of this class is that it should be instantiated.
The extra methods for this object are as following:
 + `getWeekStart()` Return starting day of the current week in YYYY/MM/DD format.
 + `getWeekEnd()` Return ending day of the current week in YYYY/MM/DD format
 + `getStartWeekOfMonth()` Return starting week number of the current month
 + `getEndWeekOfMonth()` Return ending week number of the current month
 + `getWoM()` Return 1-based number of week in the current month
 + `getWoMString()` Return a simple string as 'هفته سوم شهریور'
 + `getIsLeap()` Checks the specified year for a leap year.
 
```php
$jalali = new JalaliX(1345, 6, 18);

var_export($jalali->getIsLeap());
//false

echo JalaliX::date('Y/m/d H:i:s');
//Class khans\utils\components\JalaliX should not be called statically. use parent class Jalali.

echo JalaliX::date('Y/m/d H:i:s', time());
//Class khans\utils\components\JalaliX should not be called statically. use parent class Jalali

echo $j->getStartWeekOfMonth(); //Shahrivar 1, 1345 was in the 22th week of the year .
//22

echo $j->getEndWeekOfMonth(); //Shahrivar 31, 1345 was in the 26th week of the year.
//26

echo $j->getWoM(); //Shahrivar 18, 1345 was in the 3rd week of the month.
//3

echo $j->getWeekStart(); //3rd week of the Shahrivar 1345 was started on Sharivar 12th.
//1345/06/12

echo $j->getWeekEnd(); //3rd week of the Shahrivar 1345 was ended on Shahrivar 20th.
//1345/06/20

echo $j->getWoMString();
//هفته سوم شهریور
```
