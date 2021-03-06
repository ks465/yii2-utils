<?php


namespace khans\utils\demos\controllers;

use khans\utils\components\ArrayHelper;
use khans\utils\demos\data\MultiFormatData;
use khans\utils\demos\data\SysEavAttributes;
use khans\utils\demos\data\SysEavValues;
use khans\utils\demos\data\TestWorkflowEvents;
use khans\utils\demos\workflow\{WF, Multiple1WF, Multiple2WF, Multiple3WF};
use Yii;
use yii\db\Exception;
use khans\utils\components\workflow\KHanWorkflowHelper;
use khans\utils\demos\data\TestWorkflowMixed;
use khans\utils\demos\workflow\DeficientWF;
use khans\utils\models\UserTable;

/**
 * Default controller for the `khan` module
 *
 * @package KHanS\Utils
 * @version 0.5.0-980316
 * @since 1.0
 */
class DefaultController extends KHanWebController
{

    /**
     * Renders the index view for the module after logging
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identityClass::findOne(1);

        Yii::$app->user->switchIdentity($user);

        return $this->render('index');
    }

    /**
     * Generate multiple records with simple data for testing workflow events and other features. These data are used
     * for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetUsers()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        /* @var $connection \yii\db\Connection */
        $connection = Yii::$app->get('test')->createCommand();
        $connection->delete('sys_history_database', ['table' => 'sys_users'])->execute();

        $connection->truncateTable('sys_users')->execute();

        $systemUser = [
            'id'            => '0',
            'username'      => 'SYSTEM',
            'auth_key'      => '!',
            'password_hash' => '~!~',
            'access_token'  => $faker->sha256,
            'name'          => 'سامانه',
            'family'        => 'خودکار',
            'email'         => 'noreply@test.khan.org',
            'status'        => UserTable::STATUS_DISABLED,
            'create_time'   => 1549020399,
        ];
        $connection->insert('sys_users', $systemUser)->execute();

        $adminUser = new UserTable();
        $adminUser->setAttribute('id', '1');
        $adminUser->setAttribute('username', 'keyhan');
        $adminUser->setAttribute('name', 'مدیر');
        $adminUser->setAttribute('family', 'سیستم');
        $adminUser->setAttribute('email', 'admin@test.khan.org');
        $adminUser->setAttribute('create_time', 1549020399);
        $adminUser->setAttribute('access_token', $faker->sha256);
        $adminUser->setAttribute('status', UserTable::STATUS_ACTIVE);
        $adminUser->generateAuthKey();
        $adminUser->generateAccessToken();
        $adminUser->setPassword('123456');
        $connection->insert('sys_users', $adminUser->attributes)->execute();

        for ($i = 2; $i <= 10; $i++) {
            $time = $faker->unixTime;
            $output = [
                'id'            => $i,
                'username'      => $faker->userName,
                'auth_key'      => Yii::$app->security->generateRandomString(),
                'access_token'  => null,
                'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                'name'          => $faker->firstName,
                'family'        => $faker->lastName,
                'email'         => $faker->email,
                'status'        => $faker->randomElement(array_keys(UserTable::getStatuses())),
                'create_time'   => 1549020399 + 60 * $i,
            ];
            $connection->insert('sys_users', $output)->execute();
        }

        Yii::$app->session->addFlash('success', 'Users\' Data reset successfully (10 records).');

        return $this->redirect('index');
    }
    /**
     * Renders a page containing definition of a selected workflow along with visual representation of workflow
     *
     * @return string
     */
    public function actionWorkflow()
    {
        $selectedWF = $email = '';
        $allModels = $model = null;
        $showVisual = false;

        $source = '@khan/demos/workflow';
        $files = [
            'DeficientWF' => (new DeficientWF())::getDefinition()['metadata']['description'],
            'WF' => (new WF())::getDefinition()['metadata']['description'],
            'Multiple1WF' => (new Multiple1WF())::getDefinition()['metadata']['description'],
            'Multiple2WF' => (new Multiple2WF())::getDefinition()['metadata']['description'],
            'Multiple3WF' => (new Multiple3WF())::getDefinition()['metadata']['description'],
        ];

        if (Yii::$app->request->isPost) {
            $selectedWF = Yii::$app->request->post('workflow_select');

            $model = new \khans\utils\demos\data\TestWorkflowEvents();
            $model->enterWorkflow($selectedWF);

            $check = KHanWorkflowHelper::checkWorkflowStructure($model->getWorkflow());
            if ($check['result'] === false) {
                foreach ($check['messages'] as $key => $message) {
                    \Yii::$app->session->addFlash('error', $key . ':<br/>' . implode('<br/>', $message));
                }
            }

            $allModels = $model->getWorkflow()->getAllStatuses();
            $email = KHanWorkflowHelper::getDefaultMailTemplate($model->getWorkflow());
            $showVisual = true;
        }else {
            $selectedWF = 'WF';
        }

        return $this->render('@khan/tools/views/default/workflow', [
            'selectedWF' => $selectedWF,
            'files' => $files,
            'defaultEmail' => $email,
            'testModel' => $model,
            'showVisual' => $showVisual,
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $allModels, 'pagination' => false,]),]);
    }

    /**
     * Generate multiple records with simple data for testing workflow events and other features. These data are used
     * for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetWorkflow()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        /* @var $connection \yii\db\Connection */
        $connection = Yii::$app->get('test')->createCommand();
        $connection->delete('sys_history_database', ['table' => 'test_workflow_events'])->execute();
        $connection->delete('sys_history_emails', ['responsible_model' => 'test_workflow_events'])->execute();
        $connection->truncateTable(TestWorkflowEvents::tableName())->execute();

        for ($i = 1; $i <= 25; $i++) {
            $time = $faker->unixTime;
            $output = [
                'id' => $i,
                'title' => $faker->city,
                'workflow_status' => $faker->randomElement($this->getWFStatuses()), 'status' => $faker->boolean(75) * 10, 'created_by' => $faker->randomElement([1, 2, 3, 4]), 'created_at' => $time, 'updated_by' => $faker->randomElement([1, 2, 3, 4]), 'updated_at' => $time + $faker->randomNumber(7),];
            $connection->insert('test_workflow_events', $output)->execute();
        }

        Yii::$app->session->addFlash('success', 'Test Data reset successfully (' . TestWorkflowEvents::find()->count() . ' records).');

        return $this->redirect('index');
    }

    /**
     * Prepare a list of statuses in the test workflow `WF` for updating data
     *
     * @return array
     */
    private function getWFStatuses()
    {
        $list = ArrayHelper::getValue(WF::getDefinition(), 'status');
        $list = array_keys($list);

        return array_map(function ($item) {
            return 'WF/' . $item;
        }, $list);
    }

    /**
     * Generate multiple records with various data types in the test database sample data. These data are used for
     * demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetTable()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        $connection = Yii::$app->get('test')->createCommand();

        $connection->truncateTable(MultiFormatData::tableName())->execute();
        for ($i = 1; $i <= 50; $i++) {
            $output = ['pk_column' => $i, 'integer_column' => $faker->year, 'text_column' => $faker->firstName, 'real_column' => $faker->randomFloat(3, 123, 321), 'boolean_column' => $faker->boolean(75), 'timestamp_column' => $faker->unixTime, 'progress_column' => $faker->randomElement($this->getWFStatuses()), 'status' => $faker->boolean(75) * 10, 'created_by' => $faker->randomElement([1, 2, 3, 4]), 'created_at' => $faker->unixTime, 'updated_by' => $faker->randomElement([1, 2, 3, 4]), 'updated_at' => $faker->unixTime,];
            $connection->insert(MultiFormatData::tableName(), $output)->execute();
        }

        Yii::$app->session->addFlash('success', 'Test Data reset successfully (' . MultiFormatData::find()->count() . ' records).');

        return $this->redirect('index');
    }

    /**
     * Generate multiple EAV records in the test database for the sample table. These data are used for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetEav()
    {
        $attributes = [[1, 'multi_format_data', 'eav_column_1', 'انتخاب شماره یک', 'number', '', 'default', 10, 1, 1, 1551710131, 1555586032,], [2, 'multi_format_data', 'test_column_2', 'آزمایش شماره ۲', 'string', '31', 'default', 10, 1, null, 1554907734, 1555918637,], [3, 'dummy_table_1', 'dummy_1', 'Dummy One 1', 'number', '', 'default', 0, 1, null, 1554910143, 1555918693,], [4, 'dummy_table_2', 'dummy_1', 'Dummy Two 1', 'boolean', '', 'default', 0, 1, null, 1554910197, 1555918678,], [5, 'multi_format_data', 'test_column_3', 'ستون شماره سه آزمایشی', 'boolean', '', 'default', 4, 1, 1, 1555588602, 1555588602,], [6, 'dummy_table_3', 'dummy_attribute', 'Dummy Disabled Table Attribute', 'string', '31', 'default', 4, null, null, 1555918738, 1555918738,], [7, 'multi_format_data', 'test_column_4', 'ستون شماره چهار آزمایشی', 'boolean', '', 'default', 10, 1, 1, 1555588602, 1555588602,],];
        $fields = ['id', 'entity_table', 'attr_name', 'attr_label', 'attr_type', 'attr_length', 'attr_scenario', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at',];

        $connection = Yii::$app->get('test')->createCommand();
        $connection->truncateTable(SysEavAttributes::tableName())->execute();
        foreach ($attributes as $attribute) {
            $connection->insert(SysEavAttributes::tableName(), array_combine($fields, $attribute))->execute();
        }

        Yii::$app->session->addFlash('success', 'EAV Test Attributes reset successfully (' . SysEavAttributes::find()->count() . ' records).');

        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        $connection->truncateTable(SysEavValues::tableName())->execute();

        $activeTables = SysEavAttributes::find()->indexBy('id')
            ->asArray()
            ->all();
        foreach ($activeTables as &$item) {
            try {
                $count = min(10, Yii::$app->get('test')
                    ->createCommand('SELECT COUNT(*) FROM ' . $item['entity_table'])
                    ->queryScalar());
            } catch (Exception $e) {
                $count = 0;
            }

            $item['count'] = $count;
        }

        for ($i = 1; $i <= 100; $i++) {
            $id = $faker->randomElement(array_keys($activeTables));
            $count = $activeTables[$id]['count'];
            switch ($activeTables[$id]['attr_type']) {
                case 'boolean':
                    $value = $faker->boolean(75);
                    break;
                case 'number':
                    $value = $faker->randomNumber(3);
                    break;
                default:
                    $value = $faker->firstName;
            }
            if ($count == 0) {
                continue;
            }
            $recordId = $faker->numberBetween(1, $count);
            $status = MultiFormatData::find()->where(['pk_column' => $recordId])
                ->select(['status'])
                ->scalar();
            $output = ['id' => $i, 'attribute_id' => $id, 'record_id' => $recordId, 'value' => (string) $value, 'status' => $status, 'created_by' => $faker->randomElement([1, 2, 3, 4]), 'created_at' => $faker->unixTime, 'updated_by' => $faker->randomElement([1, 2, 3, 4]), 'updated_at' => $faker->unixTime,];
            try {
                $connection->insert(SysEavValues::tableName(), $output)->execute();
            } catch (\Exception $e) {}
        }

        Yii::$app->session->addFlash('success', 'EAV Test Data Reset Successfully (' . SysEavValues::find()->count() . ' records).');

        return $this->redirect('index');
    }

    /**
     * Prepare a list of statuses in the test ixed/multiple workflow `Multiple?WF` for updating data
     *
     * @return array
     */
    private function getMixedWFStatuses()
    {
        $a = ArrayHelper::getValue(\khans\utils\demos\workflow\Multiple1WF::getDefinition(), function ($item) {
            return array_map(function ($item) {
                return 'Multiple1WF/' . $item;
            }, array_keys($item['status']));
        });
        $b = ArrayHelper::getValue(\khans\utils\demos\workflow\Multiple2WF::getDefinition(), function ($item) {
            return array_map(function ($item) {
                return 'Multiple2WF/' . $item;
            }, array_keys($item['status']));
        });
        $c = ArrayHelper::getValue(\khans\utils\demos\workflow\Multiple3WF::getDefinition(), function ($item) {
            return array_map(function ($item) {
                return 'Multiple3WF/' . $item;
            }, array_keys($item['status']));
        });

        return array_merge($a, $b, $c);
    }

    /**
     * Generate multiple records with simple data for testing mixed/multiple workflow. These data are used for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetMixedWorkflow()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        /* @var $connection \yii\db\Connection */
        $connection = Yii::$app->get('test')->createCommand();
        $connection->delete('sys_history_database', ['table' => 'test_workflow_mixed'])->execute();
        $connection->delete('sys_history_emails', ['responsible_model' => 'test_workflow_mixed'])->execute();
        $connection->truncateTable(TestWorkflowMixed::tableName())->execute();

        for ($i = 1; $i <= 100; $i++) {
            $time = $faker->unixTime;
            $output = ['id' => $i, 'title' => $faker->city, 'workflow_status' => $faker->randomElement($this->getMixedWFStatuses()), 'status' => $faker->boolean(75) * 10, 'created_by' => $faker->randomElement([1, 2, 3, 4]), 'created_at' => $time, 'updated_by' => $faker->randomElement([1, 2, 3, 4]), 'updated_at' => $time + $faker->randomNumber(7),];
            $connection->insert('test_workflow_mixed', $output)->execute();
        }

        Yii::$app->session->addFlash('success', 'Test Data reset successfully (' . TestWorkflowMixed::find()->count() . ' records).');

        return $this->redirect('index');
    }

}