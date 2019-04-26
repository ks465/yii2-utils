<?php
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel khans\utils\demos\data\SysEavAttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of EAV Attributes';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-eav-attributes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider'       => $dataProvider,
        'filterModel'        => $searchModel,
        'columns'            => require(__DIR__.'/_columns.php'),
        'export'             => true,
        'showRefreshButtons' => true,
        'itemLabelSingle'    => 'داده',
        'itemLabelPlural'    => 'داده‌ها',
        'createAction'       => [
            'ajax' => false,
        ],
    ]); ?>
</div>
