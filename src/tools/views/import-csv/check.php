<?php
/* @var yii\web\View $this */

/* @var array $tableColumns */
/* @var array $csvColumns */
/* @var array $csvData */
/* @var array $tableData */
/* @var string $tableName */
/* @var string $filename */
/* @var integer $tableDataCount */

/* @var string $id */

/* @var string $db */


use kartik\form\ActiveForm;
use khans\utils\widgets\ConfirmButton;
use khans\utils\widgets\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'بررسی ساختار داده جدول و فایل';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
$this->params['breadcrumbs'][] = $this->title;

$diff_1 = array_diff($tableColumns, $csvColumns);
$diff_2 = array_diff($csvColumns, $tableColumns);

?>
<div class="row small">
    <div id="csv-data" class="col-md-6">
        <h3>فایل: <?= $filename ?></h3>
        <?= GridView::widget([
            'id'              => 'csv-datatable-pjax',
            'title'           => 'داده‌های موجود در فایل دریافت شده',
            'dataProvider'    => new ArrayDataProvider([
                'allModels' => $csvData, 'pagination' => ['pageSize' => 10],
            ]),
            'columns'         => $csvColumns,
            'itemLabelSingle' => 'رکورد',
            'itemLabelPlural' => 'رکورد',
        ]) ?>
    </div>
    <div id="table-data" class="col-md-6">
        <h3>جدول: <?= $tableName ?>
            <small>(<?= $tableDataCount ?> رکورد)</small>
        </h3>
        <?= GridView::widget([
            'id'              => 'table-datatable-pjax',
            'title'           => 'نمونه داده‌های کنونی جدول انتخاب شده',
            'dataProvider'    => new ArrayDataProvider(['allModels' => $tableData]),
            'columns'         => $tableColumns,
            'itemLabelSingle' => 'رکورد',
            'itemLabelPlural' => 'رکورد',
        ]) ?>
    </div>
</div>
<div class="row">
    <?php
    if (empty($diff_1) and empty($diff_2)):

        $form = ActiveForm::begin(['id' => 'truncate-import-csv']);
        echo \yii\helpers\Html::hiddenInput('id', $id);

        echo ConfirmButton::widget([
            'formID'         => $form->id,
            'formAction'     => Url::to(['truncate', 'id' => $id]),
            'buttonLabel'    => 'خالی کن',
            'buttonClass'    => 'btn btn-danger col-md-2',
            'title'          => 'از بین رفتن همه داده‌های جدول',
            'message'        => Html::tag('h3', 'همه داده‌های جدول انتخاب شده پاک خواهند شد.' . '<br/>' .
                    'این فرایند برگشت ناپذیر است!', ['style' => 'color: #d9534f']) . '<br/>' . 'آیا اطمینان دارید؟',
            'btnOKLabel'     => 'داده‌ها را پاک کن',
            'btnCancelLabel' => 'دست نگهدار',
            'btnOKIcon'      => 'fire',
            'btnCancelIcon'  => 'time',
        ]);
        ActiveForm::end();

        $form = ActiveForm::begin(['id' => 'check-import-csv']);
        echo \yii\helpers\Html::hiddenInput('id', $id);
        ?>

        <a class="btn btn-default col-md-2 col-md-offset-2" title="دوباره آغاز کن"
           href="<?= Url::to(['index', 'db' => $db]) ?>">برگرد</a>

        <button type="submit" class="btn btn-success col-md-2" title="تنها رکوردهای تازه را اضافه کن"
                formaction="<?= Url::to(['insert-all', 'id' => $id]) ?>">تازه‌ها را اضافه کن
        </button>
        <button type="submit" class="btn btn-primary col-md-2" title="تنها رکوردهای قبلی را به‌روز کن"
                formaction="<?= Url::to(['update-all', 'id' => $id]) ?>">قبلی‌ها را به‌روز کن
        </button>
        <button type="submit" class="btn btn-warning col-md-2" title="رکوردهای تازه را اضافه کن و قبلی‌ها را به‌روز کن"
                formaction="<?= Url::to(['upsert-all', 'id' => $id]) ?>">همه را اضافه کن
        </button>
        <?php
        ActiveForm::end();
    else:
        ?>
        <h4 class="alert alert-warning">
            ساختار جدول انتخاب شده با ساختار فایل دریافت شده سازگار نیست. امکان بارگذاری وجود ندارد.
            <a class="btn btn-primary pull-left" title="دوباره آغاز کن"
               href="<?= Url::to(['index', 'id' => $id]) ?>">ویرایش گزینه‌ها</a>
        </h4>
    <?php
    endif;
    ?>
</div>
