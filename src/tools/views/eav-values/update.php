<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavValues */


if (!Yii::$app->request->isAjax) {
    $this->title = 'ویرایش EAV Values Table: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => 'EAV Values Table', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'ویرایش';
}
?>
<div class="sys-eav-values-update">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
