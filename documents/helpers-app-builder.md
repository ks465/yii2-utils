#AppBuilder Class

Create a console command named `app-builder`.

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

###generateCrud
Generate separate pages for CRUD actions. 
+ $controllerClass FQN controller class ending with Controller 
+ $modelClass FQN model class
+ $viewPath URL to view path. Aliases are acceptable.
+ $indexWidget grid -> GridView, list -> ListView

###generateAjaxCrud
Generated AJAX dialogs for CRUD actions
+ $controllerClass FQN controller class ending with Controller 
+ $modelClass FQN model class
+ $viewPath URL to view path. Aliases are acceptable.
