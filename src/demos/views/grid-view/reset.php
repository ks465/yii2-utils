<?php

/* @var $this yii\web\View */
/* @var $id mixed */

if (!Yii::$app->request->isAjax) {
    $this->title = 'Grid View Demo Pages';
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'Grid View Demo Pages', 'url' => ['/demos/grid-view']];
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<h2>This is a Test <mark>Reset</mark> Page.</h2>
<h3>for id #<?= $id ?></h3>