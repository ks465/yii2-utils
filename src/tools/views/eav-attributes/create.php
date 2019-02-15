<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\tools\models\SysEavAttributes */

if (!Yii::$app->request->isAjax) {
    $this->title = 'افزودن به EAV Attributes Table';
    $this->params['breadcrumbs'][] = ['label' => 'EAV Attributes Table', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="sys-eav-attributes-create">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
