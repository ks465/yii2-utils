<?php

use khans\utils\widgets\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\tools\models\search\SysHistoryDatabaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تاریخچه ویرایش رکوردهای جدولهای سامانه';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-history-database-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'sys-history-database-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__ . '/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'footer'             => '<strong class="text-info pull-left ltr">'. '* These are EAV Fields' . '</strong>',
        ]) ?>
    </div>
</div>
