#ViewHelper Class
This class contains all the utilities required for simpler and better view of objects in output.
Normally output of the methods in this class is used only in the views.

##implode
This method converts an array into a string. This is the default output:

```php
$data = ['titleA' => 'valueA3', 'titleB' => 'valueB3',];
echo ViewHelper::implode($data);
//titleA: valueA3 titleB: valueB3

$data = [
    ['titleA' => 'valueA1', 'titleB' => 'valueB1',],
    ['titleA' => 'valueA2', 'titleB' => 'valueB2',],
    ['titleA' => 'valueA3', 'titleB' => 'valueB3',],
];
var_dump(ViewHelper::implode($data));
//0: titleA: valueA1
//titleB: valueB1
//1: titleA: valueA2
//titleB: valueB2
//2: titleA: valueA3
//titleB: valueB3

$data = [
    ['titleA' => 'valueA1', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
    ['titleA' => 'valueA2', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
    ['titleA' => 'valueA3', 'titleB' => ['titleC' => 'valueC1', 'titleD' => 'valueD1',],],
];
var_dump(ViewHelper::implode($data));
//0: titleA: valueA1
//titleB: titleC: valueC1
//titleD: valueD1
//1: titleA: valueA2
//titleB: titleC: valueC1
//titleD: valueD1
//2: titleA: valueA3
//titleB: titleC: valueC1
//titleD: valueD1
```

##formatNID
This method formats Iranian national ID number into official form by adding separating dashes. The output consists of 
Persian numerals instead of normal digits.

```php
echo ViewHelper::formatNID(12345678);
//۰۰۱-۲۳۴۵۶۷-۸

echo ViewHelper::formatNID(123456789);
//۰۱۲-۳۴۵۶۷۸-۹

echo ViewHelper::formatNID(1234567890);
//۱۲۳-۴۵۶۷۸۹-۰
```
##formatPhone
This method formats Iranian phone numbers into more readable by adding multiple dashes to it. The output consists of 
Persian numerals instead of normal digits.
This method fails to show a correct view for international numbers, even it is indeed in Iran.

```php
echo ViewHelper::formatPhone(2112345678); //Tehran 8-digit phone numbers
//۰۲۱-۱۲-۳۴-۵۶-۷۸

echo ViewHelper::formatPhone(9001234567); //Mobile phone numbers
//۰۹۰۰-۱۲۳-۴۵-۶۷

echo ViewHelper::formatPhone(1231234567); //All provincial line numbers other than Tehran
//۰۱۲۳-۱۲۳-۴۵-۶۷
'''
