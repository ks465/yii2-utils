<?php

use khans\utils\widgets\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $columns array */
/* @var $title string */
/* @var $config array */
/* @var $description string */


$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
$this->params['breadcrumbs'][] = $this->title;

if (!isset($config)) {
    $config = [];
}

?>
<h2><?= $description ?></h2>
<div class="row">
    <div class="alert alert-info col-md-6">
        <h3>Action Column Setup</h3>

        <?php
        if (isset($columns['action'])) {
            vd($columns['action']);
        } else {
            echo 'Not Set';
        }
        ?>
    </div>
    <div class="alert alert-info col-md-6">
        <h3>GridView Config</h3>

        <?php
        if (isset($config)) {
            vd($config);
        } else {
            echo 'Not Set';
        }
        ?>
    </div>
</div>
<div class="alert alert-primary">
    <?= GridView::widget([
            'id'              => 'gv-dd-a',
            'title'           => false,
            'dataProvider'    => $dataProvider,
            'columns'         => $columns,
            'itemLabelSingle' => 'I.T.E.M',
            'itemLabelPlural' => 'I.T.E.M.S',
        ] + $config) ?>
</div>
