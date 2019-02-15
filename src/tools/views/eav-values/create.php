<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavValues */

if (!Yii::$app->request->isAjax) {
    $this->title = 'افزودن به EAV Values Table';
    $this->params['breadcrumbs'][] = ['label' => 'EAV Values Table', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="sys-eav-values-create">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
