<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcParents */

$this->title = 'افزودن به List of records having children data';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'List of records having children data', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-parents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
