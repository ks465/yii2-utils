<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 10/01/19
 * Time: 17:25
 */


namespace khans\utils\tests\demos;


use app\models\ColumnsTest;
use app\models\ColumnsTestSearch;
use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use khans\utils\components\Jalali;
use khans\utils\widgets\GridView;
use khans\utils\widgets\WorkflowField;
use yii\db\Exception;
use yii\helpers\Html;

class TestColumns extends BaseTester
{
    /**
     * @var ColumnsTest a test record for WorkflowWidget
     */
    private $WFRecord;

    protected $skipTests = [
//        'testWithoutColumns',
//        'testSomeColumns',
//        'testWorkflowView',
//        'testWorkflowCreate',
//        'testWorkflowEdit',
    ];

    //<editor-fold Desc="Column Types">
    private function buildParentData()
    {
        if (\Yii::$app->db->createCommand('SELECT COUNT(*) FROM `upsert_data`;')->queryScalar() > 10) {
            return;
        }
        $faker = \Faker\Factory::create();
        $faker->seed(26465);

        for ($i = 0; $i < 10; $i++) {
            $output = [
                'grade'      => $faker->randomElement(['MSc', 'PhD']),
                'field_name' => $faker->firstNameFemale,
                'year'       => $faker->numberBetween(1380, 1390),
                'faculty'    => $faker->randomDigit,
                'status'     => $faker->numberBetween(0, 2),
                'r_a'        => $faker->randomFloat(),
                'r_b'        => $faker->randomFloat(),
                'created_by' => $faker->firstName,
                'created_at' => $faker->unixTime,
                'updated_by' => $faker->firstName,
                'updated_at' => $faker->unixTime,
            ];
            try {
                \Yii::$app->db->createCommand()->insert('upsert_data', $output)->execute();
            } catch (Exception $e) {
                echo '.';
            }
        }
    }

    private function prepareData()
    {
        echo 'Query Params';
        vd(\Yii::$app->request->queryParams);

        $this->buildParentData();

        if (\Yii::$app->db->createCommand('SELECT COUNT(*) FROM `columns_test`;')->queryScalar() > 10) {
            return;
        }
        $faker = \Faker\Factory::create();
        $faker->seed(26465);
        for ($i = 0; $i < 100; $i++) {
            $output = [
                'boolean_column'      => $faker->boolean(35),
                'tiny_column'         => $faker->boolean(75),
                'enum_column'         => $faker->numberBetween(6, 9),
                'string_date_column'  => $faker->numberBetween(1388, 1390) . '/' . $faker->numberBetween(1, 12) . '/' . $faker->numberBetween(1, 25),
                'integer_date_column' => Jalali::mktime($faker->numberBetween(1388, 1390), $faker->numberBetween(1, 12), $faker->numberBetween(1, 25)),
                'progress_column'     => 'TestWF/' . $faker->randomElement(['one', 'two', 'three', 'four', 'five']),
                'related_column'      => $faker->numberBetween(1, 4),
                'string_column'       => $faker->colorName,
            ];
            \Yii::$app->db->createCommand()->insert('columns_test', $output)->execute();
        }
    }

    private function addColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            [
                'class' => 'khans\utils\columns\RadioColumn',
            ],
            [
                'class' => 'khans\utils\columns\ActionColumn',
                'runAsAjax'      => true,
                'extraItems'=>[
                    'with-confirm' =>[
                        'icon'=> 'ban-circle',
                        'method' => 'get',
                        'confirm' => [
                            'title' => 'آیا از فرستادن این گزینه اطمینان دارید؟',
                            'message' => 'با انجام این عمل:' . '<ul>' .
                                '<li>' .
                                'پرونده نامبرده بزای اقدام فرستاده خواهد شد.' .
                                '</li>' .
                                '<li>' .
                                'به جریان افتادن پرونده نامبرده از طریق ایمیل به وی اعلام خواهد شد.' .
                                '</li>' .
                                '</ul>' .
                                'آیا اطمینان دارید؟'
                        ],
                    ],
                    'generic-confirm' =>[
                        'method' => 'post',
                        'confirm' => true,
                        'icon'=> 'ok',
                    ],
                    'no-confirm' =>[
                        'method' => 'post',
                        'icon'=> 'road',
                    ],
                ],
            ],
            [
                'attribute' => 'boolean_column',
                'class'     => 'khans\utils\columns\BooleanColumn',
            ],
            [
                'attribute' => 'tiny_column',
                'class'     => 'khans\utils\columns\BooleanColumn',
            ],
            [
                'attribute' => 'enum_column',
                'class'     => 'khans\utils\columns\EnumColumn',
                'enum'      => [6 => 'Six', 'Seven', 'Eight', 'Nine'],
            ],
            [
                'attribute' => 'string_date_column',
                'class'     => 'khans\utils\columns\DataColumn',
            ],
            [
                'attribute' => 'integer_date_column',
                'class'     => 'khans\utils\columns\JalaliColumn',
                'JFormat'   => 'Y/m/d', // Jalali::KHAN_SHORT,
            ],
//            [
//                'attribute'  => 'progress_column',
//                'class'      => 'khans\utils\columns\ProgressColumn',
//                'workflowID' => 'TestWF',
//                'width'      => '200px',
//            ],
            [
                'attribute'   => 'related_column',
                'class'       => 'khans\utils\columns\RelatedColumn',
                'targetModel' => 'app\models\UpsertData',
                'titleField'  => 'field_name', // in the parent table
            ],
            [
                'attribute' => 'string_column',
                'class'     => 'khans\utils\columns\DataColumn',
            ],
            [
                'class' => 'kartik\grid\CheckboxColumn',
            ],
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
        ];
    }

    private function configWidgetModel($id)
    {
        $model = new ColumnsTestSearch();

        return [
            'id'                 => $id,
            'dataProvider'       => $model->search(\Yii::$app->request->queryParams),
            'filterModel'        => $model,
            'title'              => 'Testing Action Columns -- Model',
            'showRefreshButtons' => true,
        ];
    }

    public function testWithoutColumns()
    {
        $this->prepareData();
        $config = $this->configWidgetModel('no-columns-test');
        $config['title'] = 'Grid View Column is Empty.';
        $config['dataProvider']->query->andWhere(['<', 'id', 10]);
        vd($config);
        echo GridView::widget($config);
    }

    public function testSomeColumns()
    {
        if(\Yii::$app->request->isPost){
            vd(\Yii::$app->request->post());
        }
        if(\Yii::$app->request->isGet){
            vd(\Yii::$app->request->get());
        }

        $this->prepareData();
        $config = $this->configWidgetModel('testSomeColumns-test');
        $config['title'] = 'testSomeColumns';
        $config['columns'] = $this->addColumns();

        $config['footer'] = '<p>' . 'Jalali as String is treated as string and entering parts of date works.' . '</p>';

        vd($config);
        echo GridView::widget($config);
    }
    //</editor-fold>

    //<editor-fold Desc="Workflow Widget">
    private function loadModelWithWorkflow()
    {
        $this->WFRecord = ColumnsTest::findOne(40);
    }

    public function testWorkflowView()
    {
        $this->loadModelWithWorkflow();
        echo DetailView::widget([
            'model'      => $this->WFRecord,
            'attributes' => [
                'id',
//                'value' => WorkflowField::widget([
//                    'attribute' => 'progress_column',
//                    'model'     => $this->WFRecord,
//                    'mode'      => WorkflowField::MODE_VIEW,
//                ]),
                'boolean_column',
                'tiny_column',
                'enum_column',
                'string_date_column',
                'integer_date_column',
                'related_column',
                'string_column',
            ],
        ]);
    }

    public function testWorkflowCreate()
    {
        $this->WFRecord = new ColumnsTest();
        $form = ActiveForm::begin();

//        echo $form->field($this->WFRecord, 'progress_column')->widget(WorkflowField::class);

        echo Html::submitButton('Send');
        ActiveForm::end();
    }

    public function testWorkflowEdit()
    {
        $this->loadModelWithWorkflow();
        $form = ActiveForm::begin();

//        echo $form->field($this->WFRecord, 'progress_column')->widget(WorkflowField::class);

        echo Html::submitButton('Send');
        ActiveForm::end();
    }
    //</editor-fold>
}
