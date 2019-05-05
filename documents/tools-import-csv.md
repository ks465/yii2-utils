#ImportCsvController
Documentation Edition: 1.0-980210
Class Version: 0.1.0-9802-08

This controller reads user data and uploads a CSV file to the server. 
Afterward it compares the structure of target table and the file.
If they match user can go forward and write data to the table.
The steps are as follows:

1. Start (`index` action of the controller): asks for database connection to use for searching
tables and uploading the data. 

1. Select (`select` action of the controller): gathers required data including:
   + Target table
   + CSV file
   + Field Delimiter --default to `,`
   + Text quotation --defaults to `"`

1. Check (`check` action of the controller): shows preview of both table data and CSV data.
If the structures match, user has following options
(_All of these methods accept only `POST`_):.
   + Truncate: truncate the table before action.
   + Insert: only insert new record (based on table constraints). 
   This will not update previous records. 
   + Update: only update existing records.
   This will not insert new records.
   + Upsert: insert new records and update existing ones.

1. Result (`result` action of the controller): shows result of action, number of changes,
and also a view of the table in its current state.


###Demo
In the demo module there is a link to use main controller with test data.
+ Use `test` as the database connection.
+ There are four CSV files in the `@demo/data` directory, for testing importer:
1. `text-import-init.csv` is meant to be the initial data before *any* import.
1. `text-import-insert.csv` contains both new records and updating ones comparing to init file. 
1. `text-import-update.csv` contains both new records and updating ones comparing to init file. 
1. `text-import-upsert.csv` contains both new records and updating ones comparing to init file.

The two last columns of these files define the initial state of the record and final one, 
if they are used with the corresponding command.