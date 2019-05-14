<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowEvents */

if (!Yii::$app->request->isAjax) {
    $this->title = 'ویرایش Test Workflow Events: ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
    $this->params['breadcrumbs'][] = ['label' => 'Test Workflow Events with EAV', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'ویرایش';
}
?>
<div class="test-workflow-events-update">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
