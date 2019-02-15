#AppBuilder Class
Documentation Edition: 2.0-971112
Class Version: 1.4.1-971020

Example:

Create a console command named `app-builder` extending the component.

```
./yii app-builder/single-model students_demands_categories StudentsDemandsCategories \\student\\modules\\demand\\models
./yii app-builder/single-model students_demands - \\student\\modules\\demand\\models

./yii app-builder/multi-models students_demand* \\student\\modules\\demand\\models

./yii app-builder/crud staff\\modules\\students\\controllers\\DemandCategoriesController student\\modules\\demand\\models\\StudentsDemandsCategories @staff/modules/students/views/demand-categories list ajax

./yii app-builder/ajax-crud staff\\modules\\students\\controllers\\DemandCategoriesController student\\modules\\demand\\models\\StudentsDemandsCategories @staff/modules/students/views/demand-categories list ajax
```
```php
$this->builder->unlinkSingleModel('SysUsersApplicant', Settings::NS_MODELS );
$this->builder->unlinkSingleModel('SysUsersApplicantQuery' , Settings::NS_MODELS . '\\queries');
$this->builder->unlinkMultiModels('SysUsers*' , Settings::NS_MODELS);
$this->builder->unlinkMultiModels('SysUsers*' , Settings::NS_MODELS . '\\queries');

```

###generateSingleModel
+ $tableName very simple, bare text, name of table in the database.
+ $modelName CamelCase name of class acting as the model
   - If this is a dash (`-`), the model name will be created using Yi:Inflector::calmelize(). The first and second examples above produce the same model.
+ $modelsNS namespace of the generated model
+ $baseModelClass fully qualified name of the base class for generated model. Defaults to '\\khans\\utils\\models\\KHanModel' 
+ $baseQueryClass fully qualified name of the base class for generated query. Defaults to '\\khans\\utils\\models\\queries\\KHanQuery'.

###generateMultiModels
+ $tableName common part of names of multiple tables ending with wildcard `*`. As the third example.
+ $modelsNS namespace of the generated models
+ $baseModelClass fully qualified name of the base class for generated model. Defaults to '\\khans\\utils\\models\\KHanModel' 
+ $baseQueryClass fully qualified name of the base class for generated query. Defaults to '\\khans\\utils\\models\\queries\\KHanQuery'.

###unlinkSingleModel
+ $modelClass basename of the class --excluding the namespace-- to remove
+ $modelNS namespace of the model
*You have to take care of queries classes separately.*

###unlinkMultiModels
+ $models common part of names of multiple classes ending with wildcard `*`. These classes should share a common namespace.
+ $modelsNS namespace of the models

###generateCrud
Generate separate pages for CRUD actions. 
+ $controllerClass FQN controller class ending with Controller 
+ $modelClass FQN model class
+ $viewPath URL to view path. Aliases are acceptable.
+ $tableTitle a title for the table (may be the table comment), which will be used as page title in the generated pages.
+ $baseControllerClass fully qualified name of the base class for generated controller. Defaults to [[\\khans\\utils\\controllers\\KHanWebController]]
+ $indexWidget grid -> GridView, list -> ListView

###generateAjaxCrud
Generate AJAX modal pages for CRUD actions. This type only produces GridView index page.
+ $controllerClass FQN controller class ending with Controller 
+ $modelClass FQN model class
+ $viewPath URL to view path. Aliases are acceptable.
+ $tableTitle a title for the table (may be the table comment), which will be used as page title in the generated pages.
+ $baseControllerClass fully qualified name of the base class for generated controller. Defaults to [[\\khans\\utils\\controllers\\KHanWebController]]

###generateUserCrud
Generate special CRUD pages for user tables. This method is a fork of [[generateAjaxCrud]] specially designed for manipulating users' data. See [[generateAjaxCrud]] for arguments.

###generateUserAuth
Generate authentication pages for users, including `login`, `logout`, `sign-up`, and `password-reset`. This is not really a CRUD controller. 
+ $controllerClass FQN controller class ending with Controller 
+ $modelClass base name of user model class
+ $viewPath URL to view path. Aliases are acceptable.
+ $modelNS namespace of the auth forms.
+ $baseControllerClass fully qualified name of the base class for generated controller. Defaults to [[\\khans\\utils\\controllers\\KHanWebController]]

###generateController
Generate a controller for the given list of actions
+ $controllerClass FQN controller class ending with Controller 
+ $actions List of empty actions in the generated controller, all in lower case separated with comma.
+ $viewPath directory path or alias for the view files
+ $baseClass fully qualified name of the base class for generated controller. Defaults to [[\\khans\\utils\\controllers\\KHanWebController]]

###unlinkController
Remove controller and its view files. It is a wrapper for [[unlinkCrud]] method. See [[unlinkCrud]] for arguments.

###unlinkCrud
Remove controller and its view files.
+ $controllerClass FQN controller class ending with Controller 
+ $viewPath URL to view path. Aliases are acceptable.
