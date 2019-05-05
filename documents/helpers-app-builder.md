#AppBuilder Class
Documentation Edition: 2.1-980205
Class Version: 1.5.0-980130

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

###Generic Generators
+ generateModelGeneric($config = [])

In the following example of the argument all parameters set to false are required to be set.
The other values show the defaults.

```php
$config = [
//    'tableName'                  => false,
//    'modelClass'                 => false,
//    'queryClass'                 => false,
//    'ns'                         => false,
//    'queryNs'                    => false,
    'db'                         => 'db',
    'generateQuery'              => true,
    'baseClass'                  => '\\khans\\utils\\models\\KHanModel',
    'queryBaseClass'             => '\\khans\\utils\\models\\queries\\KHanQuery',
    'generateLabelsFromComments' => true,
    'interactive'                => false,
    'overwrite'                  => true,
    'template'                   => 'default',
];
```

+ generateCrudGeneric($config = [])

In the following example of the argument all parameters set to false are required to be set.
The other values show the defaults.

```php
$config = [
//    'controllerClass'     => false,
//    'modelClass'          => false,
//    'searchModelClass'    => false,
//    'viewPath'            => false,
//    'tableTitle'          => false,
    'indexWidgetType'     => 'grid',
    'baseControllerClass' => '\\khans\\utils\\controllers\\KHanWebController',
    'enablePjax'          => true,
    'interactive'         => false,
    'template'            => 'giiCrudList',
];
```

+ generateParentChildModule($config = [])

The following setup is designed for a demo module pair in demo module.

```php
$config = [
    'interactive'                => true,//for BOTH models and BOTH controllers
    'overwrite'                  => true,//for BOTH models and BOTH controllers
    'generateLabelsFromComments' => true,//for BOTH models
    'db'                         => 'test',//for BOTH models
    'ns'                         => '\\khans\\utils\\demos\\data',//for BOTH models
    'queryNs'                    => '\\khans\\utils\\demos\\data',//for BOTH models
    'generateQuery'              => true,//for BOTH models
    'baseClass'                  => '\\khans\\utils\\demos\\data\\KHanModel',//for BOTH models
    'childModelTemplate'         => 'default',//for CHILD model ONLY
    'childTableName'             => 'pc_children',//for CHILD model ONLY
    'childModelClass'            => 'PcChildren',//for CHILD model ONLY
    'childQueryClass'            => 'PcChildrenQuery',//for CHILD model ONLY
    'childLinkFields'            => 'table_id,',//for CHILD model ONLY
    'parentModelTemplate'        => 'default',//for PARENT model ONLY
    'parentTableName'            => 'pc_parents',//for PARENT model ONLY
    'parentModelClass'           => 'PcParents',//for PARENT model ONLY
    'parentQueryClass'           => 'PcParentsQuery',//for PARENT model ONLY
    'parentTitleField'           => 'comment',//for PARENT model ONLY
    'baseControllerClass'        => '\\khans\\utils\\controllers\\KHanWebController',//for BOTH controllers
    'childControllerTemplate'    => 'default',//for CHILD controller ONLY
    'childEnablePjax'            => true,//for CHILD controller ONLY
    'childControllerClass'       => '\\khans\\utils\\demos\\controllers\\PcChildrenController',//for CHILD controller ONLY
    'childSearchModelClass'      => '\\khans\\utils\\demos\\data\\PcChildrenSearch',//for CHILD controller ONLY
    'childViewPath'              => '@khans/utils/demos/views/pc-children',//for CHILD controller ONLY
    'childTableTitle'            => 'List of data having parent record',//for CHILD controller ONLY
    'parentControllerTemplate'   => 'giiCrudList',//for PARENT controller ONLY
    'parentEnablePjax'           => false,//for PARENT controller ONLY
    'parentControllerClass'      => '\\khans\\utils\\demos\\controllers\\PcParentsController',//for PARENT controller ONLY
    'parentSearchModelClass'     => '\\khans\\utils\\demos\\data\\PcParentsSearch',//for PARENT controller ONLY
    'parentViewPath'             => '@khans/utils/demos/views/pc-parents',//for PARENT controller ONLY
    'parentTableTitle'           => 'List of records having children data',//for PARENT controller ONLY
    'childColumnsPath'           => '__DIR__ . \'/../pc-children',//for PARENT controller ONLY
    'childControllerId'          => '/demos/pc-children',//for PARENT controller ONLY
    'parentControllerId'         => '/demos/pc-parent',//for CHILD controller ONLY
];
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
