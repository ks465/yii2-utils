<?php

use khans\utils\widgets\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\tools\models\search\SysHistoryUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تاریخچه ورود به سامانه';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-history-users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'sys-history-users-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__ . '/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
        ]) ?>
    </div>
</div>
