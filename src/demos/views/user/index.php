<?php
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\SysUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'کاربران سامانه';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-users-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=GridView::widget([
            'id'                 => 'sys-users-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__.'/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'bulkAction'         => [
                'action'  => 'bulk-delete',
                'label'   => 'پاک‌کن',
                'icon'    => 'trash',
                'class'   => 'btn btn-danger btn-xs',
                'message' => 'آیا اطمینان دارید همه را پاک کنید؟',
                'hint'    => 'همه کاربران انتخاب شده را',
            ],
            'createAction'       => [
                'ajax' => true,
            ],
            'footer'             => 'برای دیدن تلاشهای ورود با شناسه نادرست، گزارش ورود برای کاربر سامانه خودکار را ببینید.',
            'itemLabelSingle'    => 'کاربر',
            'itemLabelPlural'    => 'کاربر',
        ])?>
</div>
