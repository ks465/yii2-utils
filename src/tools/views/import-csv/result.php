<?php
/* @var yii\web\View $this */

/* @var string $id */
/* @var string $action */
/* @var $data \yii\base\DynamicModel */
/* @var array $tableData */
/* @var string $tableName */

/* @var array $tableColumns */

use khans\utils\widgets\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

$this->title = 'Result of Importing CSV';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
$this->params['breadcrumbs'][] = $this->title;

?>
<p class="alert alert-info">
    فایل
    <strong><?= $data->file->name ?></strong>
    برای
    <?= $action ?>
    به جدول
    <strong><?= $data->table ?></strong>
    انتخاب شده بود.
    تعداد
    <strong><?= $data->success ?></strong>
    رکورد با موفقیت انجام شد و تعداد
    <strong><?= $data->dropped ?></strong>
    نیز براساس انتخاب انجام نشد.
    ویرایش رکوردهای پیشین تنها در صورت تغییر انجام شده است.
</p>
<div id="table-data">
    <h3>جدول: <?= $tableName ?>
        <a class="btn btn-primary pull-left" title="بارگذاری یک فایل دیگر"
           href="<?= Url::to(['index']) ?>">آغاز تازه</a>
    </h3>
    <?= GridView::widget([
        'id'              => 'table-datatable-pjax',
        'title'           => 'نمونه داده‌های نهایی جدول انتخاب شده',
        'dataProvider'    => new ArrayDataProvider(['allModels' => $tableData]),
        'columns'         => $tableColumns,
        'itemLabelSingle' => 'رکورد',
        'itemLabelPlural' => 'رکورد',
    ]) ?>
</div>
<p>

</p>