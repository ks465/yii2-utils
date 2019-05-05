<?php


$this->title = 'Jalali Date Picker';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Components Demo Pages', 'url' => ['/demos/components']];
$this->params['breadcrumbs'][] = $this->title;

$time = time();

$idCounter = 0;

$examplesJalali = [
    'khans\utils\widgets\DatePicker::widget([
            \'id\'        => \'test-picker-id\',
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m/d\', time())]),
            \'options\'   => [
                \'todayBtn\' => false,
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m/d\', time())]),
            \'options\'   => [
                \'minViewMode\' => \'days\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m\', time())]),
            \'options\'   => [
                \'minViewMode\' => \'months\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y\', time())]),
            \'options\'   => [
                \'minViewMode\' => \'years\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y\', time())]),
            \'options\'   => [
                \'format\' => \'yyyy\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m\', time())]),
            \'options\'   => [
                \'format\' => \'yyyy/mm\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m/d\', time())]),
            \'options\'   => [
                \'format\' => \'yyyy/mm/dd\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m/d\', time())]),
            \'options\'   => [
                \'startDate\' => \'1395/06/18\',
            ],
        ]);',
    'khans\utils\widgets\DatePicker::widget([
            \'attribute\' => \'from_date\',
            \'model\'     => new yii\base\DynamicModel([\'from_date\' => khans\utils\components\Jalali::date(\'Y/m/d\', time())]),
            \'options\'   => [
                \'startDate\' => \'1395/06/18\',
                \'endDate\'   => \'1398/01/01\',
                \'todayBtn\'  => false,
            ],
        ]);',
];
?>
<div class="ltr">
    <h3>Jalali Date Picker</h3>
    <?php foreach ($examplesJalali as $item) : ?>
        <div class="row well">
            <code class=" col-sm-9">
                <?= nl2br($item) ?>
            </code>
            <div class="col-sm-3">
                <?= eval('return ' . $item) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<pre class="ltr">
$form = kartik\form\ActiveForm::begin();
echo $form->field(
    new yii\base\DynamicModel(['from_date' => khans\utils\components\Jalali::date('Y/m', time())]),
    'from_date'
)
->widget(khans\utils\widgets\DatePicker::className(), [
    'options'     => [
        'format'     => 'yyyy/mm/dd',
        'viewformat' => 'yyyy/mm/dd',
        'placement'  => 'left',
        'todayBtn'   => 'linked',
    ],
    'htmlOptions' => [
        'id'    => 'date',
        'class' => 'form-control',
    ],
]);
$form->end();
</pre>

