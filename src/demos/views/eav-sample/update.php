<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\MultiFormatEav */


if (!Yii::$app->request->isAjax) {
    $this->title = 'ویرایش EAV Sample Data: ' . $model->pk_column;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'EAV Sample Data', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->pk_column, 'url' => ['view', 'id' => $model->pk_column]];
    $this->params['breadcrumbs'][] = 'ویرایش';
}
?>
<div class="multi-format-eav-update">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
