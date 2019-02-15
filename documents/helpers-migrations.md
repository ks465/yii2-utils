#Migrations
Documentation Edition: 1.2-971122
Class Version: 0.5.2-971122

[[KHanMigration]] is the base class for migration. It has multiple new methods

+ Character set is set for MariaDB to UTF8, with collate UTF*_PERSIAN_CI
+ MariaDB engine is set to InnoDB
+ `smallPrimaryKey` defines `small integer` field type for PK
+ `bit` defines a type which is translated into PHP `boolean` type. If the database does not support it, `boolean` is set instead.
+ `longText` defines `long text` with drop back to `text`
+ `longBlob` defines `long blob` with drop back to `binary`
+ `latinChar` defines `char` with the given length and collate of `latin1_general_ci`
+ createTableWithLoggers adds fields to the field definition of the table:
   - status
   - created_by
   - created_at
   - updated_by
   - updated_at
+ addLoggersFields defines the fields to be added by `createTableWithLoggers`
+ comment adds a comment to the table
+ enum adds an ENUM typed field
+ isSQLite checks to see if the database is SQLite
+ isMSSQL checks to see if the database is MS SQL
+ isOracle checks to see if the database is Oracle
+ readStdIn reads input from the user to fill records of the generated table with initial values
+ load loads data from CSV file to initialize table
+ addLoggers sets data for initializing the logger fields

##Files
+ m130524_201442_CreateUserTables.php Create user tables for auth actions.
+ m140506_102106_InitRbacTables.php Create RBAC tables.
+ m140602_111327_CreateMenuTable.php Create menu table for application main menu.
+ m190103_083414_InitSystemTables.php Create two tables for structure of system critical tables. See [SystemTableBuilder](helpers-system-table-builder.md) for more details.
+ m190128_152310_CreateHistoryTables.php Creates two table for logging history.
   - one for saving the history of changes in the models extending [[KHanModel]]
   - one for saving history of login attempts to site.

##Init System tables
Two system table containing table definition and field definitions
