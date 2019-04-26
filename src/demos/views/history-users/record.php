<?php

use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\search\SysHistoryDatabaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$columns = require(__DIR__ . '/_columns.php');
unset($columns[7]);
unset($columns[0]);
?>
<div class="sys-history-database-record small">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'                 => 'sys-history-record-pjax',
            'dataProvider'       => $dataProvider,
            'columns'            => $columns,
            'panel'              => false,
            'gridIsModal'        => true,
            'showRefreshButtons' => false,
        ]) ?>
    </div>
</div>
