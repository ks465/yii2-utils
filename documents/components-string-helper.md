#StringHelper Class
This class contains all the utilities for formatting, correcting and shaping strings for saving or showing.

## PERSIAN_NAME 
This constant defines a regular expression pattern to filter alphabet characters which are valid in names.

##PERSIAN_TITLE
This constants defines a regular expression pattern to filter alphabet, numbers (both Persian & Latin type faces), punctuations,
and other characters usually used in titles of books, papers, etc.

##screenInput
In order to make sure all of Persian inputs are corrected for the Ya & Ka before application starts processing the input.
[[correctYaKa]] is called in this method. For this to work you should add the following to the Yii2 main config:

```php
    'on beforeRequest' => [
    'KHanS\Utils',
    'screenInput',
],
* ```

##correctYaKa
Unfortunately, older Microsoft keyboards and fonts used arabic characters `ك` and `ي` instead of `ی` and `ک`. 
This results in inconsistent search results. To solve this problem use [[correctYaKa]] to convert all occurrence of 
these two letters to the standard Persian ones (which are `ی` and `ک`). 
This function is used in [[screenInput]] to ensure simple and solid using of Persian language sites.

##trimAll
Trim strings in any data depth but do not change the key of associative arrays.

##convertDigits
Convert Latin digits into Persian-faced numerals and vice versa. This is for display reasons, and by using an appropriate
font, this is not really needed --except for the decimal point character.

##mb_str_pad
Padding multi byte characters is not as simple as ASCII characters. As it is seen in the following example length of multi-byte
characters is not calculated correctly in `PHP::str()`. In this rewrite the real length of words is calculated, and further
to that this method considers the no-width no-break space in Persian. 

```php
$length = 12;

echo str_pad($text1, $length, '-',STR_PAD_LEFT);
//راه انداز

echo StringHelper::mb_str_pad($text1, $length, '-',STR_PAD_LEFT);
//---راه انداز

echo str_pad($text2, $length, '-',STR_PAD_LEFT);
//راه‌انداز

echo StringHelper::mb_str_pad($text2, $length, '-',STR_PAD_LEFT);
//----راه‌انداز

$length = 20;

echo str_pad($text1, $length, '-',STR_PAD_LEFT);
//---راه انداز

echo StringHelper::mb_str_pad($text1, $length, '-',STR_PAD_LEFT);
//-----------راه انداز

echo str_pad($text2, $length, '-',STR_PAD_LEFT);
//-راه‌انداز

echo StringHelper::mb_str_pad($text2, $length, '-',STR_PAD_LEFT);
//------------راه‌انداز
```