#Jalali and JalaliX Classes

Jalali class is an attempt to use astronomical calculations of Khayyam and keep the interface 
as similar as possible to `PHP::date()` function.

Jalali has two main public methods:
1. `Jalali::date()` which by accepting format and timestamp returns a date string:

1. `Jalali::mktime()` which accepts elements of date and time and returns timestamp integer:
 
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