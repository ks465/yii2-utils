<?php

use khans\utils\components\Jalali;
use khans\utils\components\JalaliX;
use khans\utils\widgets\GridView;

$this->title = 'Jalali Date Converter';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Components Demo Pages', 'url' => ['/demos/components']];
$this->params['breadcrumbs'][] = $this->title;

$time = time();

$examplesJalali = [
    [
        'statement' => 'Jalali::date(\'Y/m/d H:i:s\')',
        'result'    => Jalali::date('Y/m/d H:i:s'),
    ],
    [
        'statement' => 'Jalali::date(\'Y/m/d H:i:s\', time(), false)',
        'result'    => Jalali::date('Y/m/d H:i:s', time(), false),
    ],
    [
        'statement' => 'Jalali::getYear()',
        'result'    => Jalali::getYear(),
    ],
    [
        'statement' => 'Jalali::timestamp()',
        'result'    => Jalali::getTimestamp(),
    ],
    [
        'statement' => 'Jalali::getMinute()',
        'result'    => Jalali::getMinute(),
    ],
    [
        'statement' => 'Jalali::getDoW()',
        'result'    => Jalali::dayOfWeek(),
    ],
    [
        'statement' => 'Jalali::date(\'o\', $time)',
        'result'    => Jalali::date('o', $time),
    ],
    [
        'statement' => 'Jalali::date(\'t\', $time)',
        'result'    => Jalali::date('t', $time),
    ],
    [
        'statement' => 'Jalali::date(\'u\', $time)',
        'result'    => Jalali::date('u', $time),
    ],
];
$dpJalali = new \yii\data\ArrayDataProvider(['allModels' => $examplesJalali]);

$jalaliX = new JalaliX(1345, 6, 18);

$examplesJX = [
    [
        'statement'   => 'JalaliX::getYear()',
        'static call' => JalaliX::getYear(),
        'method'      => 'JalaliX->getYear()',
        'method call' => $jalaliX->getYear(),
    ],
    [
        'statement'   => 'JalaliX::getTimestamp()',
        'static call' => JalaliX::getTimestamp(),
        'method'      => 'JalaliX->getTimestamp()',
        'method call' => $jalaliX->getTimestamp(),
    ],
    [
        'statement'   => 'JalaliX::getMinute()',
        'static call' => JalaliX::getMinute(),
        'method'      => 'JalaliX->getMinute()',
        'method call' => $jalaliX->getMinute(),
    ],
    [
        'statement'   => 'JalaliX::dayOfWeek()',
        'static call' => JalaliX::dayOfWeek(),
        'method'      => 'JalaliX->dayOfWeek()',
        'method call' => $jalaliX->dayOfWeek(),
    ],
    [
        'statement'   => 'JalaliX::date(\'Y/m/d H:i:s\')',
        'static call' => 'N/A, See the Notes.',
        'method'      => 'JalaliX->date(\'Y/m/d H:i:s\')',
        'method call' => 'N/A, See the Notes.',
    ],
];
$dpJX = new \yii\data\ArrayDataProvider(['allModels' => $examplesJX]);

?>
<div class="row">
    <div class="ltr col-md-5">
        <h3>Jalali Component</h3>
        <?= GridView::widget([
            'dataProvider' => $dpJalali,
        ]) ?>
    </div>
    <div class="ltr col-md-7">
        <h3>JalaliX Component initiated as:
            <h4>$jalaliX = new JalaliX(1345, 6, 18);</h4>
            <?= GridView::widget([
                'dataProvider' => $dpJX,
            ]) ?>
    </div>
</div>
<h4 class="ltr alert alert-warning">
    Class khans\utils\components\Jalali should not be instantiated. Use static methods only.
    <br/>
    Class khans\utils\components\JalaliX should not be called statically. use parent class Jalali.
</h4>
