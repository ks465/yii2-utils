<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\PcChildren */

if (!Yii::$app->request->isAjax) {
    $this->title = 'افزودن به List of data having parent record';
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'List of data having parent record', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="pc-children-create">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
