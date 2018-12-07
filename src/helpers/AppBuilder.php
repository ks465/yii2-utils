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
 * Class AppBuilder does some cool stuff to make life easier in development period.
 *
 * @package khans\utils
 * @version 1.3.1-970915
 * @since   1.0
 */
class AppBuilder extends BaseObject
{
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
            \Yii::$app->runAction('gii/model', [
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
                'template'                   => 'khanGii',
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
        foreach (preg_grep('/' . $tableName . '/', \Yii::$app->db->schema->tableNames) as $table) {
            try {
                $result += self::generateSingleModel($table, '-', $modelsNS, $baseModelClass, $baseQueryClass);
            } catch (Exception $e) {
                echo $e->getMessage();

                return ExitCode::USAGE;
            }
        }

        return $result;
    }

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
            $modelFilename = \Yii::getAlias('@' . str_replace('\\', '/', $modelNS) . '/' . $modelClass . '.php');
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
            throw new InvalidConfigException('You did not end the models names with *. May be you should use [[unlinkMultiModels]]');
        }

        $result = ExitCode::OK;
        $glob = \Yii::getAlias('@' . str_replace('\\', '/', $modelsNS) . '/' . $models . '.php');
        foreach (glob($glob) as $filename) {
            if (!unlink($filename)) {
                $result = ExitCode::OSERR;
            }
        }

        return $result;
    }

    /**
     * Create or overwrite CRUD for the given model in the given namespace
     *
     * @param string $controllerClass controller fully qualified class with namespace in CamelCase (with first
     *    uppercase letter and ending with Controller (app\\controllers\\PostController)
     * @param string $modelClass fully qualified model class with namespace used (app\\models\\Post)
     * @param string $viewPath Directory path or alias for the view files.
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     * @param string $indexWidget type of widget used in the index page. It can be GridView (default) or ListView.
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateCrud($controllerClass, $modelClass, $viewPath, $baseControllerClass = null,
        $indexWidget = 'grid'): int
    {
        $controllersDirectory = dirname(\Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            mkdir($controllersDirectory);
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }
        try {
            \Yii::$app->runAction('gii/crud-list', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'searchModelClass'    => $modelClass . 'Search',
                'viewPath'            => $viewPath,
                'indexWidgetType'     => $indexWidget,
                'baseControllerClass' => $baseControllerClass,
                'enablePjax'          => true,
                'interactive'         => false,
                'template'            => 'khanGii',
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
     * @param string $baseControllerClass fully qualified name of the base class for generated controller. Defaults to
     *     [[\\khans\\utils\\controllers\\KHanWebController]]
     *
     * @return int ExitCode If completed successfully
     */
    public static function generateAjaxCrud($controllerClass, $modelClass, $viewPath, $baseControllerClass = null): int
    {
        $controllersDirectory = dirname(\Yii::getAlias('@' . str_replace('\\', '/', $controllerClass)));

        if (!is_dir($controllersDirectory)) {
            mkdir($controllersDirectory);
        }

        if (is_null($baseControllerClass)) {
            $baseControllerClass = '\\khans\\utils\\controllers\\KHanWebController';
        }

        try {
            \Yii::$app->runAction('gii/crud-ajax', [
                'controllerClass'     => $controllerClass,
                'modelClass'          => $modelClass,
                'searchModelClass'    => $modelClass . 'Search',
                'viewPath'            => $viewPath,
                'baseControllerClass' => $baseControllerClass,
                'interactive'         => false,
                'template'            => 'khanGii',
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
            $controllerFilename = \Yii::getAlias('@' . str_replace('\\', '/', $controllerClass) . '.php');
        } catch (InvalidArgumentException $e) {
            Console::error($e->getMessage());

            return ExitCode::UNAVAILABLE;
        }

        if (file_exists($controllerFilename)) {
            if (!unlink($controllerFilename)) {
                return ExitCode::OSERR;
            }
        }

        $glob = \Yii::getAlias($viewPath) . '/*';
        foreach (glob($glob) as $filename) {
            if (!unlink($filename)) {
                return ExitCode::OSERR;
            }
        }

        return ExitCode::OK;
    }
}
