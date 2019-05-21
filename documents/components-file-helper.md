#FileHelper Class
Documentation Edition: 1.1-980226

Class Version: 1.2.1-950423

This class contains simplified methods to read and write some types of files:
1. `loadCSV` read data from a CSV file into preferably associated array.
1. `saveCSV` write data to a CSV file. 
Header row is forced to exist in the output file. If it is not provided, array keys of the first row will be used.
1. `loadIni` read data from an ini file into associative array.

There is no method for writing INI files. They are supposed to be readonly to the application.

*Important:* `loadCSV` uses `PHP::fgetcsv`, and it does _NOT_ complains about non-CSV files.
It is user's responsibility to be sure the file is real CSV. It is pareses as CSV anyway.
