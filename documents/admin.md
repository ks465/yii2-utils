#Admin Class

This class contains methods to make life easier and fun for the admins.
Debugger part of this class is a wrapper for [[VarDump]] class. It provides following methods for debugging:

1. `vd` Dump one _or more_ variables and continue execution.
1. `vdd` Dump one *or more* variables. This method will stop your script after the dump.  
1. `vdc` Dump _only one_ variable and continue execution.
1. `vdcd` Dump *only one* variable. This method will stop your script after the dump.  
1. `sql` Show a formatted text of an SQL query.
1. `sqld` Show a formatted text of an SQL query. This method will stop your script after the dump.

##VarDump Class
This is a third party class offering dumping variables with ability to expand or hide parts of data. In this way it can
keep the display clear.
The original class has multiple themes included, which are named after comic strip heroes. They are kept the same to avoid
changing the code very much.  