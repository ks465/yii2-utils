<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysEavAttributes */

$this->title = 'افزودن به List of EAV Attributes';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'List of EAV Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-eav-attributes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
