<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\TestWorkflowMixed */

if (!Yii::$app->request->isAjax) {
    $this->title = 'افزودن به Test Workflow Mixed';
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
    $this->params['breadcrumbs'][] = ['label' => 'Test Workflow Mixed', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="test-workflow-mixed-create">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
