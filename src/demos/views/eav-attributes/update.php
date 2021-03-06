<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavAttributes */

$this->title = 'ویرایش List of EAV Attributes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'List of EAV Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="sys-eav-attributes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
