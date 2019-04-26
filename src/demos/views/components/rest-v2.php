<?php

use khans\utils\components\rest_v2\RestQuery;
use khans\utils\widgets\GridView;

$this->title = 'Rest Client for PostgREST';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Components Demo Pages', 'url' => ['/demos/components']];
$this->params['breadcrumbs'][] = $this->title;


$rest_f_s = new  RestQuery();
$rest_f_s->from('oci_students_list')
    ->select([
        'student_id',
        'student_name',
        'student_family',
        'department_id',
    ])
    ->where(['enter_type' => 801])
    ->andWhere(['student_gender' => 102])
    ->andFilterWhere(['student_id' => Yii::$app->request->getQueryParam('student_id', '')])
    ->andFilterWhere(['like', 'student_name', Yii::$app->request->getQueryParam('student_name', '')])
    ->orderBy([
        'student_family' => SORT_ASC,
        'student_name'   => SORT_ASC,
    ]);

$searchModel = new \khans\utils\components\rest_v2\RestSearchModel([
    'query' => $rest_f_s,
]);
//vdd($searchModel->attributes);
$columns = [
    [
        'class'     => 'khans\utils\columns\DataColumn',
        'attribute' => 'student_id',
    ],
    [
        'class'     => 'khans\utils\columns\DataColumn',
        'attribute' => 'student_name',
    ],
    [
        'class'     => 'khans\utils\columns\DataColumn',
        'attribute' => 'student_family',
    ],
    [
        'class'     => 'khans\utils\columns\DataColumn',
        'attribute' => 'department_id',
    ],
];

$restDP = $searchModel->search(Yii::$app->request->queryParams);
$arrayDP = new \yii\data\ArrayDataProvider([
    'id'        => 'arrayDP',
    'allModels' => $rest_f_s->all(),
]);

?>

<div class="ltr well alert alert-warning">
    <?= $rest_f_s->createCommand()->rawSql ?>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('explain($rest_f_s);') ?>
    </h3>
    <div class="col-md-8">
        <?php explain($rest_f_s); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->exists()'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->exists()); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->count()'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->count()); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->sum(\'department_id\')'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->sum('department_id')); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->average(\'student_id\')'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->average('student_id')); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->min(\'student_name\')'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->min('student_name')); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->max(\'student_family\')'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->max('student_family')); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->one()'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->one()); ?>
    </div>
</div>
<div class="row ltr well">
    <h3 class="col-md-4">
        <?php highlight_string('$rest_f_s->all()'); ?>
    </h3>
    <div class="col-md-8">
        <?php vd($rest_f_s->all()); ?>
    </div>
</div>

<h3 class="alert alert-info ltr">
    Comparing the same data and search models with two types of data providers
</h3>
<div class="col-md-6">
    <?= GridView::widget([
        'dataProvider' => $restDP,
        'title'        => 'RestDataProvider',
//        'filterModel' => $searchModel,
        'columns'      => $columns,
    ]) ?>
</div>
<div class="col-md-6">
    <?= GridView::widget([
        'dataProvider' => $arrayDP,
//        'filterModel' => $searchModel,
        'title'        => 'ArrayDataProvider',
        'columns'      => $columns,
    ]) ?>
</div>