<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 3/6/17
 * Time: 9:32 AM
 */


namespace khans\utils\helpers;

use Yii;
use yii\base\{BaseObject, InvalidArgumentException, InvalidConfigException, InvalidRouteException};
use yii\console\{Exception, ExitCode};
use yii\helpers\Console;
use yii\helpers\Inflector;

/**
 * Class AppBuilder prepares methods for generating unified controllers, models, and views based on the KHan*
 * generators.
 *
 * @package khans\utils
 * @version 1.5.1-980207
 * @since   1.0
 */
class AppBuilder extends BaseObject
{
    const ACTIONS_USER_DEFAULT = 'behaviors, actions, login, login-attempts, logout, sign-up, request-password-reset, reset-password, ';

    //<editor-fold Desc="Generic generators">
    /**
     * @var array Default values for generating CRUD. Main settings are deliberately missing.
     */
    private static $_CRUDConfig = [
//        'controllerClass'     => false,
//        'modelClass'          => false,
//        'searchModelClass'    => false,
//        'viewPath'            => false,
//        'tableTitle'          => false,
        'indexWidgetType'     => 'grid',
        'baseControllerClass' => '\\khans\\utils\\controllers\\KHanWebController',
        'enablePjax'          => true,
        'interactive'         => false,
        'template'            => 'giiCrudList',
    ];
    /**
     * @var array Default values for generating models. Main settings are deliberately missing.
     */
    private static $_ModelConfig = [
//        'tableName'                  => false,
//        'modelClass'                 => false,
//        'queryClass'                 => false,
//        'ns'                         => false,
//        'queryNs'                    => false,
        'db'                         => 'db',
        'generateQuery'              => true,
        'baseClass'                  => '\\khans\\utils\\models\\KHanModel',
        'queryBaseClass'             => '\\khans\\utils\\models\\queries\\KHanQuery',
        'generateLabelsFromComments' => true,
        'interactive'                => false,
        'overwrite'                  => true,
        'template'                   => 'default',
    ];
    /**
     * @var array Default values for generating Parent Child pattern modules
     */
    private static $_PCConfig = [
//        'ns'                         => false,//for BOTH models
//        'queryNs'                    => 'false,//for BOTH models
//        'childTableName'             => false,//for CHILD model ONLY
//        'childModelClass'            => false,//for CHILD model ONLY
//        'childQueryClass'            => false,//for CHILD model ONLY
//        'childLinkFields'            => false,//for CHILD model ONLY
//        'parentTableName'            => false,//for PARENT model ONLY
//        'parentModelClass'           => false,//for PARENT model ONLY
//        'parentQueryClass'           => false,//for PARENT model ONLY
//        'parentTitleField'           => false,//for PARENT model ONLY
//        'childControllerClass'       => false,//for CHILD controller ONLY
//        'childSearchModelClass'      => false,//for CHILD controller ONLY
//        'childViewPath'              => false,//for CHILD controller ONLY
//        'childTableTitle'            => false,//for CHILD controller ONLY
//        'parentControllerClass'      => false,//for PARENT controller ONLY
//        'parentSearchModelClass'     => false,//for PARENT controller ONLY
//        'parentViewPath'             => false,//for PARENT controller ONLY
//        'parentTableTitle'           => false,//for PARENT controller ONLY
//        'childControllerId'          => false,//for PARENT controller ONLY
//        'parentControllerId'         => false,//for CHILD controller ONLY
        'interactive'                => true,//for BOTH models and BOTH controllers
        'overwrite'                  => true,//for BOTH models and BOTH controllers
        'generateLabelsFromComments' => true,//for BOTH models
        'db'                         => 'db',//for BOTH models
        'generateQuery'              => true,//for BOTH models
        'baseClass'                  => '\\khans\\utils\\models\\KHanModel',//for BOTH models
        'parentControllerTemplate'   => 'giiCrudList',//for PARENT controller ONLY
        'childControllerTemplate'    => 'default',//for CHILD controller ONLY
        'parentModelTemplate'        => 'default',//for PARENT model ONLY
        'childModelTemplate'         => 'default',//for CHILD model ONLY
        'baseControllerClass'        => '\\khans\\utils\\controllers\\KHanWebController',//for BOTH controllers
        'childEnablePjax'            => true,//for CHILD controller ONLY
        'parentEnablePjax'           => false,//for PARENT controller ONLY
        'childColumnsPath'           => '__DIR__ . \'/../pc-children',//for PARENT controller ONLY
        'parentPK'                   => null,//for PARENT model
        'childPK'                    => null,//for CHILD model
    ];

    /**
     * Generate model using a single argument [$_ModelConfig] containing all the required parameters.
     *
     * @param array $config
     *
     * @return int
     * @throws Exception
     * @throws InvalidRouteException
     */
    public static function generateModelGeneric($config = [])
    {
        $config = array_merge(self::$_ModelConfig, $config);

        Yii::$app->runAction('gii/model', $config);

        return ExitCode::OK;
    }

    /**
     * Generate CRUD using a single argument [$_CRUDConfig] containing all the required parameters.
     *
     * @param array $config
     *
     * @return int
     * @throws Exception
     * @throws InvalidRouteException
     */
    public static function generateCrudGeneric($config = [])
    {
        $config = array_merge(self::$_CRUDConfig, $config);

        $controllersDirectory = dirname(Yii::getAlias('viewPath'));
        if (!is_dir($controllersDirectory)) {
            try {
                mkdir($controllersDirectory);
            } catch (\Exception $e) {
                Console::error($e->getMessage() . $controllersDirectory);

                return ExitCode::OSFILE;
            }
        }

        Yii::$app->runAction('gii/crud', $config);

        return ExitCode::OK;
    }

    /**
     * Generate required models and CRUD for Parent/Child Pattern combination
     *
     * @param array $config
     *
     * @throws Exception
     * @throws InvalidRouteException
     */
    public static function generateParentChildModule($config = [])
    {
        $config = array_merge(self::$_PCConfig, $config);

        //Parent Model:
        AppBuilder::generateModelGeneric([
                'interactive'                => $config['interactive'],
                'overwrite'                  => $config['overwrite'],
                'generateLabelsFromComments' => $config['generateLabelsFromComments'],
                'db'                         => $config['db'],
                'ns'                         => $config['ns'],
                'queryNs'                    => $config['queryNs'],
                'generateQuery'              => $config['generateQuery'],
                'baseClass'                  => $config['baseClass'],
                'template'                   => $config['parentModelTemplate'],
                'tableName'                  => $config['parentTableName'],
                'modelClass'                 => $config['parentModelClass'],
                'queryClass'                 => $config['parentQueryClass'],
                'typeParentChild'            => 'parent',
                'relatedModel'               => $config['ns'] . '\\' . $config['childModelClass'],
                'relatedFields'              => $config['parentTitleField'],
                'optionalPK'                 => $config['parentPK'],
            ]
        );
        //Child Model:
        AppBuilder::generateModelGeneric([
                'interactive'                => $config['interactive'],
                'overwrite'                  => $config['overwrite'],
                'generateLabelsFromComments' => $config['generateLabelsFromComments'],
                'db'                         => $config['db'],
                'ns'                         => $config['ns'],
                'queryNs'                    => $config['queryNs'],
                'generateQuery'              => $config['generateQuery'],
                'baseClass'                  => $config['baseClass'],
                'template'                   => $config['parentModelTemplate'],
                'tableName'                  => $config['childTableName'],
                'modelClass'                 => $config['childModelClass'],
                'queryClass'                 => $config['childQueryClass'],
                'typeParentChild'            => 'child',
                'relatedModel'               => $config['ns'] . '\\' . $config['parentModelClass'],
                'relatedFields'              => $config['childLinkFields'],
                'optionalPK'                 => $config['childPK'],
            ]
        );
        //Parent CRUD:
        AppBuilder::generateCrudGeneric([
                'indexWidgetType'       => 'grid',
                'interactive'           => $config['interactive'],
                'baseControllerClass'   => $config['baseControllerClass'],
                'enablePjax'            => $config['parentEnablePjax'],
                'template'              => $config['parentControllerTemplate'],
                'controllerClass'       => $config['parentControllerClass'],
                'modelClass'            => $config['ns'] . '\\' . $config['parentModelClass'],
                'searchModelClass'      => $config['parentSearchModelClass'],
                'viewPath'              => $config['parentViewPath'],
                'tableTitle'            => $config['parentTableTitle'],
                'childControllerId'     => $config['childControllerId'],
                'childColumnsPath'      => $config['childColumnsPath'],
                'childLinkFields'       => $config['childLinkFields'],
                'childSearchModelClass' => $config['childSearchModelClass'],
            ]
        );
//        Child CRUD:
        AppBuilder::generateCrudGeneric([
                'indexWidgetType'     => 'grid',
                'interactive'         => $config['interactive'],
                'baseControllerClass' => $config['baseControllerClass'],
                'enablePjax'          => $config['childEnablePjax'],
                'template'            => $config['childControllerTemplate'],
                'controllerClass'     => $config['childControllerClass'],
                'modelClass'          => $config['ns'] . '\\' . $config['childModelClass'],
                'searchModelClass'    => $config['childSearchModelClass'],
                'viewPath'            => $config['childViewPath'],
                'tableTitle'          => $config['childTableTitle'],
                'parentControllerId'  => $config['parentControllerId'],
            ]
        );
    }
    //</editor-fold>

    //<editor-fold Desc="Model generators">
    /**
     * Create or overwrite model and query for the given table in the given namespace
     *
     * @param string $tableName name of table in the database
     * @param string $modelName desired name of model
     * @param string $modelsNS path to models repository for the new model
     * @param string $baseModelClass fully qualified name of the base class for generated model. Defaults to
     *     '\\khans\\utils\\models\\KHanModel'
     * @param string $baseQueryClass fully qualified name of the base class for generated query. Defaults to
     *     '\\khans\\utils\\models\\queries\\KHanQuery'
     *
     * @return int ExitCode If completed successfully
     * @throws Exception
     */
    public static function generateSingleModel($tableName, $modelName, $modelsNS = null, $baseModelClass = null,
        $baseQueryClass = null): int
    {
        if ('-' == $modelName) {
            $modelName = Inflector::camelize($tableName);
        }

        if (is_null($modelsNS)) {
            throw new Exception('Name space for the model is not set, and default value is also missing.');
        }
        if (is_null($baseModelClass)) {
            $baseModelClass = '\\khans\\utils\\models\\KHanModel';
        }
        if (is_null($baseQueryClass)) {
            $baseQueryClass = '\\khans\\utils\\models\\queries\\KHanQuery';
        }
        try {
            Yii::$app->runAction('gii/model', [
                'generateQuery'              => true,
                'tableName'                  => $tableName,
                'modelClass'                 => $modelName,
                'queryClass'                 => $modelName . 'Query',
                'baseClass'                  => $baseModelClass,
                'queryBaseClass'             => $baseQueryClass,
                'ns'                         => $modelsNS,
                'queryNs'                    => $modelsNS . '\\queries',
                'generateLabelsFromComments' => true,
                'interactive'                => false,
                'overwrite'                  => true,
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }

    /**
     * Create or overwrite several models and queries for the given table prefix in the given namespace
     *
     * @param string $tableName Initial common part of multiple table name in the database ending with '*'
     * @param string $modelsNS path to models repository for the new model
     * @param string $baseModelClass fully qualified name of the base class for generated model. Defaults to
     *     '\\khans\\utils\\models\\KHanModel'
     * @param string $baseQueryClass fully qualified name of the base class for generated query. Defaults to
     *     '\\khans\\utils\\models\\queries\\KHanQuery'
     *
     * @return int ExitCode If all individual tables completed successfully. Otherwise it is count of errors
     * @throws InvalidConfigException When the table name does not contain wildcard `*`.
     */
    public static function generateMultiModels($tableName, $modelsNS = null, $baseModelClass = null,
        $baseQueryClass = null): int
    {
        if (strpos($tableName, '*', 1) === false) {
            throw new InvalidConfigException('You did not end the table name with *. May be you should use [[generateSingleModel]]');
        }
        $tableName = str_replace('*', '.*', $tableName);

        $result = ExitCode::OK;
        foreach (preg_grep('/' . $tableName . '/', Yii::$app->db->schema->tableNames) as $table) {
            try {
                $result += self::generateSingleModel($table, '-', $modelsNS, $baseModelClass, $baseQueryClass);
            } catch (Exception $e) {
                echo $e->getMessage();

                return ExitCode::USAGE;
            }
        }

        return $result;
    }
    //</editor-fold Desc="Model generators">

    //<editor-fold Desc="Model Removers">
    /**
     * Remove a model or query class file from filesystem.
     *
     * @param string $modelClass Name of the class to remove.
     * @param string $modelNS Namespace of the class.
     *
     * @return int
     */
    public static function unlinkSingleModel($modelClass, $modelNS): int
    {
        try {
            $modelFilename = Yii::getAlias('@' . str_replace('\\', '/', $modelNS) . '/' . $modelClass . '.php');
        } catch (InvalidArgumentException $e) {
            Console::error($e->getMessage());

            return ExitCode::UNAVAILABLE;
        }

        if (!file_exists($modelFilename)) {
            Console::error('File `' . $modelFilename . '` does not exist.');

            return ExitCode::OSFILE;
        }

        if (unlink($modelFilename)) {
            return ExitCode::OK;
        }

        return ExitCode::OSERR;
    }

    /**
     * Remove several models or queries for the given class name prefix in the given namespace
     *
     * @param string $models Initial common part of multiple class name in the given namespace ending with '*'
     * @param string $modelsNS namespace of the models repository
     *
     * @return int ExitCode If all individual files removed successfully. Otherwise it is count of errors
     * @throws InvalidConfigException When the table name does not contain wildcard `*`.
     */
    public static function unlinkMultiModels($models, $modelsNS): int
    {
        if (strpos($models, '*', 1) === false) {
            throw new InvalidConfigException('You did not end the models names with *. May be you should use [[unlinkSingleModel]]');
        }

        $result = ExitCode::OK;
        $glob = Yii::getAlias('@' . str_replace('\\', '/', $modelsNS) . '/' . $models . '.php');
        foreach (glob($glob) as $filename) {
            if (!unlink($filename)) {
                $result = ExitCode::OSERR;
            }
        }

        return $result;
    }
    //</editor-fold Desc="Model Removers">

    //<editor-fold Desc="CRUD Generators">
    /**
     * Create or overwrite CRUD for the given model in the given namespace
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $modelClass fully qualified model class with namespace used (app\\models\\Post)
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $tableTitle Title of the pages, which presumably is the comment of the database table.
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     * @param string $indexWidget type of widget used in the index page. It can be GridView (default) or ListView.
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateCrud($controllerClass, $modelClass, $viewPath, $tableTitle,
        $baseControllerClass = null,
        $indexWidget = 'grid'): int
    {
        $controllersDirectory = dirname(Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            mkdir($controllersDirectory);
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }
        try {
            Yii::$app->runAction('gii/crud', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'searchModelClass'    => $modelClass . 'Search',
                'viewPath'            => $viewPath,
                'indexWidgetType'     => $indexWidget,
                'baseControllerClass' => $baseControllerClass,
                'tableTitle'          => $tableTitle,
                'enablePjax'          => true,
                'interactive'         => false,
                'template'            => 'giiCrudList',
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }

    /**
     * Create or overwrite AJAX CRUD for the given model in the given namespace. This type only produces GridView for
     *    the index page.
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $modelClass fully qualified model class with namespace used (app\\models\\Post)
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $tableTitle Title of the pages, which presumably is the comment of the database table.
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateAjaxCrud($controllerClass, $modelClass, $viewPath, $tableTitle,
        $baseControllerClass = null): int
    {
        $controllersDirectory = dirname(Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            mkdir($controllersDirectory);
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }

        try {
            Yii::$app->runAction('gii/crud', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'searchModelClass'    => $modelClass . 'Search',
                'viewPath'            => $viewPath,
                'baseControllerClass' => $baseControllerClass,
                'tableTitle'          => $tableTitle,
                'interactive'         => false,
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }

    /**
     * Create or overwrite CRUD for the given user model in the given namespace
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $modelClass fully qualified model class with namespace used (app\\models\\Post)
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $tableTitle Title of the pages, which presumably is the comment of the database table.
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateUserCrud($controllerClass, $modelClass, $viewPath, $tableTitle,
        $baseControllerClass = null): int
    {
        $controllersDirectory = dirname(Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            try {
                mkdir($controllersDirectory);
            } catch (\Exception $e) {
                Console::error($e->getMessage() . $controllersDirectory);

                return ExitCode::OSFILE;
            }
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }
        try {
            Yii::$app->runAction('gii/crud', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'searchModelClass'    => $modelClass . 'Search',
                'viewPath'            => $viewPath,
                'baseControllerClass' => $baseControllerClass,
                'tableTitle'          => $tableTitle,
                'enablePjax'          => true,
                'interactive'         => false,
                'template'            => 'giiCrudUser',
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }

    /**
     * Create or overwrite user authentication actions for the given user model in the given namespace
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $modelClass fully qualified model class with namespace used (app\\models\\Post)
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $modelNS namespace of the auth forms.
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateUserAuth($controllerClass, $modelClass, $viewPath, $modelNS,
        $baseControllerClass = null): int
    {
        $controllersDirectory = dirname(Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            try {
                mkdir($controllersDirectory);
            } catch (\Exception $e) {
                Console::error($e->getMessage() . $controllersDirectory);

                return ExitCode::OSFILE;
            }
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }
        try {
            Yii::$app->runAction('gii/crud', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'viewPath'            => $viewPath,
                'baseControllerClass' => $baseControllerClass,
                'enablePjax'          => true,
                'authForms'           => $modelNS,
                'interactive'         => false,
                'template'            => 'giiCrudAuth',
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }
    //</editor-fold Desc="CRUD Generators">

    //<editor-fold Desc="Controller Generators">
    /**
     * Create or overwrite Controller for the given list of actions in the given namespace
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $actions List of empty actions in the generated controller, all in lower case separated with comma
     *     or space.
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $baseClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateController($controllerClass, $actions, $viewPath, $baseClass = null): int
    {
        $controllersDirectory = dirname(Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            mkdir($controllersDirectory);
        }

        if (is_null($baseClass)) {
            $baseClass = '\\khans\\utils\\controllers\\KHanWebController';
        }
        try {
            Yii::$app->runAction('gii/controller', [
                'controllerClass' => $controllerClass,
                'actions'         => $actions,
                'viewPath'        => $viewPath,
                'baseClass'       => $baseClass,
                'enablePjax'      => true,
                'interactive'     => false,
            ]);
        } catch (InvalidRouteException $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        } catch (Exception $e) {
            echo $e->getMessage();

            return ExitCode::USAGE;
        }

        return ExitCode::OK;
    }
    //</editor-fold Desc="Controller Generators">

    //<editor-fold Desc="CRUD Remover">
    /**
     * Remove Controller files for the given controller in the given namespace.
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $viewPath Directory path or alias for the view files.
     *
     * @return int ExitCode If completed successfully
     */
    public static function unlinkController($controllerClass, $viewPath): int
    {
        return self::unlinkCrud($controllerClass, $viewPath);
    }

    /**
     * Remove CRUD files for the given controller in the given namespace.
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $viewPath Directory path or alias for the view files.
     *
     * @return int ExitCode If completed successfully
     */
    public static function unlinkCrud($controllerClass, $viewPath): int
    {
        try {
            $controllerFilename = Yii::getAlias('@' . str_replace('\\', '/', $controllerClass) . '.php');
        } catch (InvalidArgumentException $e) {
            Console::error($e->getMessage());

            return ExitCode::UNAVAILABLE;
        }

        if (file_exists($controllerFilename)) {
            if (!unlink($controllerFilename)) {
                return ExitCode::OSERR;
            }
        }

        $glob = Yii::getAlias($viewPath) . '/*';
        foreach (glob($glob) as $filename) {
            if (!unlink($filename)) {
                return ExitCode::OSERR;
            }
        }

        return ExitCode::OK;
    }
    //</editor-fold Desc="CRUD Remover">
}
