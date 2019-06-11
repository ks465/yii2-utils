<?php

use kartik\detail\DetailView;
use khans\utils\components\Jalali;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysUsers */

if ($model->id == 0) {
    $passwordHash = '<strong class="text-danger">' . 'کاربر سامانه خودکار گذرواژه (رمز شده یا نشده) ندارد!' . '</strong>';
    $passwordReset ='<strong class="text-danger">' . 'کاربر سامانه خودکار گذرواژه برای بازیابی ندارد!' . '</strong>';
    $accessToken = '<strong class="text-danger">' . 'توکن کاربر سامانه خودکار در دسترس نیست!' . '</strong>';
} else {
    $passwordHash = empty($model->password_hash) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE;
    $passwordReset = empty($model->password_reset_token) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE;
    $accessToken = empty($model->access_token) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE;
}
?>
<div class="sys-users-staff-view">

    <?= DetailView::widget([
        'model'           => $model,
        'labelColOptions' => ['style' => 'width: 30%'],
        'attributes'      => [
            'id',
            'name',
            'family',
            [
                'attribute' => 'email',
                'value'     => '<div class="ltr" style="font-family: Helvetica;">' . $model->email . '</div>',
                'format'    => 'raw',
            ],
            'username',
            [
                'attribute' => 'auth_key',
                'value'     => empty($model->auth_key) ? GridView::ICON_INACTIVE : GridView::ICON_ACTIVE,
                'format'    => 'html',
            ],
            [
                'attribute' => 'password_hash',
                'value'     => $passwordHash,
                'format'    => 'html',
            ],
            [
                'attribute' => 'password_reset_token',
                'value'     => $passwordReset,
                'format'    => 'html',
            ],
            [
                'attribute' => 'access_token',
                'value'     => $accessToken,
                'format'    => 'html',
            ],
            [
                'attribute' => 'status',
                'value'     => $model->getStatus(),
            ],
            [
                'attribute' => 'last_visit_time',
                'value'     => ($model->last_visit_time == 0) ? GridView::ICON_INACTIVE : Jalali::date(Jalali::KHAN_LONG, $model->last_visit_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'create_time',
                'value'     => Jalali::date(Jalali::KHAN_LONG, $model->create_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'update_time',
                'value'     => ($model->update_time == 0) ? GridView::ICON_INACTIVE : Jalali::date(Jalali::KHAN_LONG, $model->update_time),
                'format'    => 'html',
            ],
            [
                'attribute' => 'delete_time',
                'value'     => ($model->delete_time == 0) ? GridView::ICON_INACTIVE : Jalali::date(Jalali::KHAN_LONG, $model->delete_time),
                'format'    => 'html',
            ],
        ],
    ]) ?>

</div>
