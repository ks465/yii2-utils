<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysHistoryEmails */

if (!Yii::$app->request->isAjax) {
    $this->title = 'تاریخچه ارسال ایمیل خودکار گردش کار: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
    $this->params['breadcrumbs'][] = ['label' => 'تاریخچه ارسال ایمیل خودکار گردش کار', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

$attributes = [
    'responsible_model:ntext',
    'responsible_record:ntext',
    'workflow_transition:ntext',
    'workflow_start',
    'workflow_end',
    'content:ntext',
    'user_id',
    [
        'attribute' => 'enqueue_timestamp',
        'value' => Jalali::date(Jalali::KHAN_LONG, $model->enqueue_timestamp),
    ],
    'recipient_email:ntext',
    'cc_receivers:ntext',
    'attachments:ntext',
];


?>
<div class="sys-history-emails-view">
<?php if (!Yii::$app->request->isAjax): ?>
    <h1><?= Html::encode($this->title) ?></h1>
<?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>

