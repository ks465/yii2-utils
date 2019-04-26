<?php


namespace khans\utils\demos\controllers;

use khans\utils\demos\data\MultiFormatData;
use khans\utils\demos\data\SysEavAttributes;
use khans\utils\demos\data\SysEavValues;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

/**
 * Default controller for the `khan` module
 *
 * @package KHanS\Utils
 * @version 0.2.0-980202
 * @since   1.0
 */
class DefaultController extends Controller
{
    /**
     * Action classes used in this module
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Generate multiple records with various data types in the test database sample data.
     * These data are used for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetTable()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        Yii::$app->get('test')->createCommand()->truncateTable(MultiFormatData::tableName())->execute();
        for ($i = 1; $i <= 50; $i++) {
            $output = [
                'pk_column'        => $i,
                'integer_column'   => $faker->year,
                'text_column'      => $faker->firstName,
                'real_column'      => $faker->randomFloat(3, 123, 321),
                'boolean_column'   => $faker->boolean(75),
                'timestamp_column' => $faker->unixTime,
                'progress_column'  => $faker->randomElement(['WF/One', 'WF/Two', 'WF/Three', 'WF/Four']),

                'status'     => $faker->boolean(75) * 10,
                'created_by' => $faker->randomElement([1, 2, 3, 4]),
                'created_at' => $faker->unixTime,
                'updated_by' => $faker->randomElement([1, 2, 3, 4]),
                'updated_at' => $faker->unixTime,
            ];
            $model = new MultiFormatData();
            $model->detachBehavior('Workflow');
            $model->setAttributes($output);
            $model->save();

            if ($model->hasErrors()) {
                vd($model->errors);
            }
        }

        Yii::$app->session->addFlash('success', 'Test Data reset successfully (' . MultiFormatData::find()->count() . ' records).');

        return $this->redirect('index');
    }

    /**
     * Generate multiple EAV records in the test database for the sample table.
     * These data are used for demos.
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetEav()
    {
        $attributes = [
            [
                1, 'multi_format_data', 'eav_column_1', 'انتخاب شماره یک', 'number', '', 'default', 10, 1, 1,
                1551710131, 1555586032,
            ],
            [
                2, 'multi_format_data', 'test_column_2', 'آزمایش شماره ۲', 'string', '31', 'default', 10, 1, null,
                1554907734, 1555918637,
            ],
            [
                3, 'dummy_table_1', 'dummy_1', 'Dummy One 1', 'number', '', 'default', 0, 1, null, 1554910143,
                1555918693,
            ],
            [
                4, 'dummy_table_2', 'dummy_1', 'Dummy Two 1', 'boolean', '', 'default', 0, 1, null, 1554910197,
                1555918678,
            ],
            [
                5, 'multi_format_data', 'test_column_3', 'ستون شماره سه آزمایشی', 'boolean', '', 'default', 4, 1, 1,
                1555588602, 1555588602,
            ],
            [
                6, 'dummy_table_3', 'dummy_attribute', 'Dummy Disabled Table Attribute', 'string', '31', 'default', 4,
                null, null, 1555918738, 1555918738,
            ],
            [
                7, 'multi_format_data', 'test_column_4', 'ستون شماره چهار آزمایشی', 'boolean', '', 'default', 10, 1, 1,
                1555588602, 1555588602,
            ],
        ];
        $fields = [
            'id', 'entity_table', 'attr_name', 'attr_label', 'attr_type', 'attr_length', 'attr_scenario', 'status',
            'created_by', 'created_at', 'updated_by', 'updated_at',
        ];

        Yii::$app->get('test')->createCommand()->truncateTable(SysEavAttributes::tableName())->execute();
        foreach ($attributes as $attribute) {

            $model = new SysEavAttributes();
            $model->setAttributes(array_combine($fields, $attribute));
            $model->save();

            if ($model->hasErrors()) {
                vd($model->errors);
            }
        }

        Yii::$app->session->addFlash('success', 'EAV Test Attributes reset successfully (' . SysEavAttributes::find()->count() . ' records).');


        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        Yii::$app->get('test')->createCommand()->truncateTable(SysEavValues::tableName())->execute();

        $activeTables = SysEavAttributes::find()->indexBy('id')->asArray()->all();
        foreach ($activeTables as &$item) {
            try {
                $count = min(10, Yii::$app->get('test')->createCommand('SELECT COUNT(*) FROM ' . $item['entity_table'])->queryScalar());
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
            $status = MultiFormatData::find()->where(['pk_column' => $recordId])->select(['status'])->scalar();
            $output = [
                'id'           => $i,
                'attribute_id' => $id,
                'record_id'    => $recordId,
                'value'        => (string)$value,

                'status'     => $status,
                'created_by' => $faker->randomElement([1, 2, 3, 4]),
                'created_at' => $faker->unixTime,
                'updated_by' => $faker->randomElement([1, 2, 3, 4]),
                'updated_at' => $faker->unixTime,
            ];
            $model = new SysEavValues();
            $model->setAttributes($output);
            try {
                $model->save();
            } catch (\Exception $e) {
            }

            if ($model->hasErrors()) {
                vd($model->errors);
            }
        }

        Yii::$app->session->addFlash('success', 'EAV Test Data reset successfully (' . SysEavValues::find()->count() . ' records).');

        return $this->redirect('index');
    }
}
