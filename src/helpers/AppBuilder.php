<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 3/6/17
 * Time: 9:32 AM
 */


namespace KHanS\Utils\helpers;


use KHanS\Utils\models\KHanUser;
use KHanS\Utils\Settings;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Class AppBuilder does some cool stuff to make life easier in development period.
 *
 * @package KHanS\Utils
 * @version 0.3-970803
 * @since   1.0
 */
final class AppBuilder extends \yii\console\Controller
{
    /**
     * Create or overwrite model and query for the given table in the given namespace
     *
     * @param string $tableName name of table in the database
     * @param string $modelName desired name of model
     * @param string $modelsNS  path to models repository for the new model
     *
     * @return int ExitCode If completed successfully
     * @throws \Exception When the namespace is not declared and no default value was found.
     */
    public function actionGenerateModel($tableName, $modelName, $modelsNS = null)
    {
        $modelsNS = is_null($modelsNS) ? is_null(Settings::PATH_MODELS_DIRECTORY) : $modelsNS;
        if (is_null($modelsNS)) {
            throw new \Exception('Name space for the model is not set, and default value is also missing.');
        }
        \Yii::$app->runAction('gii/model', [
            'generateQuery'              => true,
            'tableName'                  => $tableName,
            'modelClass'                 => $modelName,
            'queryClass'                 => $modelName . 'Query',
            'ns'                         => $modelsNS,
            'queryNs'                    => $modelsNS . '\\queries',
            'generateLabelsFromComments' => true,
            'interactive'                => true,
        ]);

        return ExitCode::OK;
    }

    /**
     * Set all passwords in the user table to 123456.
     * Presumably the user with `id = 1` is the admin, so do not change this one password.
     * Total number of users and number of successful changes are written to `StdOut`.
     *
     * @return int `ExitCode::OK` if all passwords are set successfully, `ExitCode::DATAERR` if at least one failed one
     *             exists.
     * @throws \yii\base\Exception When failed to create the password hash.
     */
    public function actionSetPasswords()
    {
        $query = KHanUser::find()->where(['>', 'id', 1])->orderBy(['id' => SORT_ASC]);
        $count = $query->count();
        Console::startProgress(0, $count, 'Change Staff User Passwords ', 0.5);
        $counter = 0;

        $result = ExitCode::OK;
        foreach ($query->all() as $i => $user) {
            /* @var KHanUser $user */
            $user->setPassword('123456');
            $user->status = KHanUser::STATUS_ACTIVE;

            if ($user->save()) {
                Console::updateProgress($i, $count);
                $counter++;
            } else {
                var_dump($user->id, $user->errors);
                $result = ExitCode::DATAERR;
            }
        }
        Console::endProgress(true);
        echo ". $counter out of $count user password changed.\n";

        return $result;
    }
}
