<?php
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\tools\models\search\SysHistoryEmailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تاریخچه ارسال ایمیل خودکار گردش کار';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-history-emails-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'                 => 'sys-history-emails-datatable-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__.'/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'itemLabelSingle'    => 'داده',
            'itemLabelPlural'    => 'داده‌ها',
            'bulkAction'         => false,
            'createAction'       => false,
        ])?>
    </div>
</div>
