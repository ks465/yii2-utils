#FileHelper Class
Documentation Edition: 1.0-970820
Class Version: 1.2.1-950423

This class contains simplified method to read and write some types of files:
1. [[khans\utils\components\FileHelper::loadCSV|loadCSV]] read data from a CSV file into preferably associated array.
1. [[khans\utils\components\FileHelper::saveCSV|saveCSV]] write data to a CSV file. Header row is forced to exist in the output file. If it is not provided, array 
keys of the first row will be used.
1. [[khans\utils\components\FileHelper::loadIni|loadIni]] read data from an ini file into associative array.
1. [[khans\utils\components\FileHelper::saveIni|saveIni]] write data to an ini file. Integer keys are used instead of keys 
if the input array is not associative.

Two files are placed in the `demos` directory. 
One CSV file.
One Ini file.
These are used in the demos.
