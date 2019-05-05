<?php


namespace khans\utils\tools\controllers;

use khans\utils\components\ArrayHelper;
use khans\utils\components\FileHelper;
use khans\utils\controllers\KHanWebController;
use khans\utils\models\KHanModel;
use khans\utils\tools\components\TableHelper;
use khans\utils\tools\models\SysHistoryDatabase;
use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImportCsvController implements importing csv file into tables
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-980212
 * @since   1.0
 */
class ImportCsvController extends KHanWebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'truncate'   => ['POST'],
                    'insert-all' => ['POST'],
                    'update-all' => ['POST'],
                    'upsert-all' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Start importing by selecting the database connection
     *
     * @param null|string $db preselected database connection ID
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex($db = null)
    {
        $model = new DynamicModel([
            'id', 'delimiter', 'enclosed', 'file', 'table', 'connection' => $db ?? 'db', 'success', 'dropped',
            'referer', 'actionType', 'historyTable',
        ]);
        $model->addRule('connection', 'default', ['value' => 'db']);
        $model->addRule(['connection'], 'required');
        $model->addRule(['connection', 'actionType', 'historyTable'], 'string');
        $model->addRule(['success', 'dropped'], 'integer');
        $model->addRule(['table', 'delimiter', 'enclosed', 'referer'], 'string');
        $model->addRule('delimiter', 'default', ['value' => ',']);
        $model->addRule('enclosed', 'default', ['value' => '"']);
        $model->addRule('file', 'file');

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $history = (new KHanModel())->getBehavior('history');
            $model->historyTable = ArrayHelper::getValue($history->managerOptions, 'tableName', null);

            $model->validate();
            if ($model->hasErrors()) {
                vdd($model->errors);
            }
            $sessionID = $model->connection . '-' . microtime(true);
            $model->id = $sessionID;
            Yii::$app->session->set($sessionID, $model);

            return $this->redirect(['select', 'id' => $sessionID]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Show the form for selecting file and table to import data
     *
     * @param null|string $id ID for the saved parameters of current import process
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\NotSupportedException
     */
    public function actionSelect($id = null)
    {
        $model = $this->loadData($id);

        $tablesArray = [];
        foreach ($this->getConnection($model->connection)->getSchema()->getTableNames() as $tableName) {
            $tablesArray[$tableName] = TableHelper::getTableComment($tableName) . ' (' . $tableName . ')';
        }

        $model->addRule(['table', 'file'], 'required');
        $model->addRule('table', 'in', ['range' => array_keys($tablesArray)]);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstanceByName('DynamicModel[file]');

            if ($model->validate() and !$model->hasErrors()) {
                if (!empty($model->file)) {
                    $model->file->saveAs(Yii::getAlias('@runtime/' . $model->file->name));
                    Yii::$app->session->set($id, $model);

                    return $this->redirect(['check', 'id' => $id]);
                }
            }
        }

        return $this->render('select', [
            'id'              => $id,
            'model'           => $model,
            'tablesAvailable' => ['' => ''] + $tablesArray,
        ]);
    }

    /**
     * Check the structures of the given file and chosen table for the columns.
     * Columns must be exactly the same,
     *
     * @param string $id ID for the saved parameters of current import process
     *
     * @return string
     * @throws Exception
     */
    public function actionCheck($id)
    {
        $data = $this->loadData($id);

        $csvData = FileHelper::loadCSV(Yii::getAlias('@runtime/' . $data->file->name));

        return $this->render('check', [
            'id'             => $id,
            'db'             => $data->connection,
            'filename'       => $data->file->name,
            'tableName'      => $data->table,
            'tableColumns'   => $this->getConnection($data->connection)->getTableSchema($data->table)->getColumnNames(),
            'tableData'      => $this->getConnection($data->connection)->createCommand('SELECT * FROM ' . $data->table . ' LIMIT 10;')->queryAll(),
            'tableDataCount' => $this->getConnection($data->connection)->createCommand('SELECT COUNT(*) FROM ' . $data->table . ';')->queryScalar(),
            'csvColumns'     => array_keys(next($csvData)),
            'csvData'        => $csvData,
        ]);
    }

    /**
     * Truncate the target table and add clean data
     *
     * @param string $id ID for the saved parameters of current import process
     *
     * @return \yii\web\Response
     */
    public function actionTruncate($id)
    {
        $model = $this->loadData($id);

        try {
            $this->getConnection($model->connection)->createCommand()->truncateTable($model->table)->execute();

            $model->actionType = SysHistoryDatabase::CSV_TRUNCATE;
            $this->registerHistory($model, ['field_id' => '_TABLE_', 'old_value' => null, 'new_value' => null]);
        } catch (Exception $e) {
            vd($e->getMessage(), $id, Yii::$app->request->post(), $model);
        }

        return $this->redirect(['check', 'id' => $id]);
    }

    /**
     * Insert new records from CSV file and drop the duplicated one.
     *
     * @param null|string $id ID for the saved parameters of current import process
     *
     * @return \yii\web\Response
     * @throws Exception
     */
    public function actionInsertAll($id)
    {
        $data = $this->loadData($id);
        $csvData = FileHelper::loadCSV(Yii::getAlias('@runtime/' . $data->file->name));

        $inserted = $failed = 0;
        $transaction = $this->getConnection($data->connection)->beginTransaction();
        foreach ($csvData as $row) {
            $command = $this->getConnection($data->connection)->createCommand()->insert($data->table, $row);
            try {
                $inserted += $command->execute();

                $data->actionType = SysHistoryDatabase::CSV_INSERT;
                $this->registerHistory($data, [
                    'field_id'  => 'N/A',
                    'old_value' => null,
                    'new_value' => json_encode($row),
                ]);
            } catch (Exception $e) {
                $failed++;
            }
        }
        $transaction->commit();

        $data->success = $inserted;
        $data->dropped = $failed;
        $data->referer = 'insert';
        Yii::$app->session->set($id, $data);

        return $this->redirect(['result', 'id' => $id]);
    }

    /**
     * Update existing records from CSV data and drop new ones
     *
     * @param null|string $id ID for the saved parameters of current import process
     *
     * @return \yii\web\Response
     * @throws Exception
     */
    public function actionUpdateAll($id)
    {
        $data = $this->loadData($id);
        $csvData = FileHelper::loadCSV(Yii::getAlias('@runtime/' . $data->file->name));
        $pk = array_flip($this->getConnection($data->connection)->getTableSchema($data->table)->primaryKey);

        $updated = $failed = 0;
        $transaction = $this->getConnection($data->connection)->beginTransaction();
        foreach ($csvData as $row) {
            $command = $this->getConnection($data->connection)->createCommand()->update($data->table, $row, array_intersect_key($row, $pk));
            try {
                $updated += $command->execute();

                $data->actionType = SysHistoryDatabase::CSV_UPDATE;
                $this->registerHistory($data, [
                    'field_id' => 'N/A',
                    'old_value' => null,
                    'new_value' => json_encode($row),
                ]);
            } catch (Exception $e) {
                $failed++;
            }
        }
        $transaction->commit();

        $data->success = $updated;
        $data->dropped = $failed;
        $data->referer = 'update';
        Yii::$app->session->set($id, $data);

        return $this->redirect(['result', 'id' => $id]);
    }

    /**
     * Insert new records and update previous records from CSV file
     *
     * @param null|string $id ID for the saved parameters of current import process
     *
     * @return \yii\web\Response
     * @throws Exception
     */
    public function actionUpsertAll($id)
    {
        $data = $this->loadData($id);
        $csvData = FileHelper::loadCSV(Yii::getAlias('@runtime/' . $data->file->name));

        $upserted = $failed = 0;
        $transaction = $this->getConnection($data->connection)->beginTransaction();
        foreach ($csvData as $row) {
            $command = $this->getConnection($data->connection)->createCommand()->upsert($data->table, $row);
            try {
                $upserted += $command->execute();

                $data->actionType = SysHistoryDatabase::CSV_UPSERT;
                $this->registerHistory($data, [
                    'field_id'  => 'N/A',
                    'old_value' => null,
                    'new_value' => json_encode($row),
                ]);
            } catch (Exception $e) {
                $failed++;
            }
        }
        $transaction->commit();

        $data->success = $upserted;
        $data->dropped = $failed;
        $data->referer = 'upsert';
        Yii::$app->session->set($id, $data);

        return $this->redirect(['result', 'id' => $id]);
    }

    /**
     * Show the result of action and clean session and files
     *
     * @param null|string $id ID for the saved parameters of current import process
     *
     * @return string
     */
    public function actionResult($id)
    {
        $data = $this->loadData($id);

        switch ($data->referer) {
            case 'insert':
                $action = 'افزودن رکوردهای تازه';
                break;
            case 'update':
                $action = 'به‌روز رسانی رکوردهای پیشین';
                break;
            case 'upsert':
                $action = 'افزودن رکوردهای تازه و به‌روز رسانی رکوردهای پیشین';
                break;
            default:
                $action = '';
        }

        unlink(Yii::getAlias('@runtime/' . $data->file->name));
        Yii::$app->session->set($id, null);

        return $this->render('result', [
            'id'           => $id,
            'action'       => $action,
            'tableName'    => $data->table,
            'tableColumns' => $this->getConnection($data->connection)->getTableSchema($data->table)->getColumnNames(),
            'tableData'    => $this->getConnection($data->connection)->createCommand('SELECT * FROM ' . $data->table/* . ' LIMIT 10;'*/)->queryAll(),
            'data'         => $data,
        ]);

    }

    /**
     * Load saved parameters of the process from session
     *
     * @param string $id ID for the saved parameters of current import process
     *
     * @return mixed
     */
    private function loadData($id)
    {
        return Yii::$app->session->get($id);
    }

    /**
     * Load an arbitrary database connection.
     * It is useful for application with multiple connections.
     *
     * @param string $connectionId ID for the database connection to use
     *
     * @return Connection
     */
    private function getConnection($connectionId)
    {
        if ($connectionId == 'db') {
            return Yii::$app->db;
        }
        try {
            return Yii::$app->get($connectionId);
        } catch (InvalidConfigException $e) {
            return Yii::$app->db;
        }
    }

    /**
     * Register log for data manipulation in system history table
     *
     * @param DynamicModel $data parameters of the process
     * @param array        $updates changes in form of [field_id, old_value, new_value]
     *
     * @return int
     */
    private function registerHistory($data, $updates)
    {
        Yii::$app->session->set($data->id, $data);

        $row = [
                'user_id'    => isset(Yii::$app->user->id) ? Yii::$app->user->id : '',
                'table'      => $data->table,
                'date'       => date('Y-m-d H:i:s', time()),
                'type'       => $data->actionType,
                'field_name' => 'CSV File: ' . $data->file->name,

            ] + $updates;
//vdd($data->connection, $data->historyTable, $row);
        $command = $this->getConnection($data->connection)->createCommand()->insert($data->historyTable, $row);

//explain($command->getRawSql());
        return $command->execute();
    }
}
