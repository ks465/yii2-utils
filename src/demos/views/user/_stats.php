<?php
use yii\helpers\Html;
use khans\utils\components\Jalali;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
/* @var $model khans\utils\demos\data\SysUsers */
?>
<hr />
<div class="row small sys-users-stats">
	<div class="col-lg-6 ltr">
		<p>
			<label>Auth Key: </label>
            <?= strlen($model->auth_key) > 0 ? GridView::ICON_ACTIVE : GridView::ICON_INACTIVE ?>
        </p>
		<p>
			<label>Password Hash: </label>
            <?= strlen($model->password_hash) > 0 ? GridView::ICON_ACTIVE : GridView::ICON_INACTIVE ?>
        </p>
		<p>
			<label>Access Token: </label>
            <?= strlen($model->access_token) > 0 ? GridView::ICON_ACTIVE : GridView::ICON_INACTIVE ?>
        </p>
		<p>
			<label>Password Reset Token: </label>
            <?= strlen($model->password_reset_token) > 0 ? GridView::ICON_ACTIVE : GridView::ICON_INACTIVE ?>
        </p>
	</div>
	<div class="col-lg-6">
		<p>
			<label>آخرین ورود: </label>
            <?= Jalali::date(Jalali::KHAN_SHORT, $model->last_visit_time) ?>
        </p>
		<p>
			<label>آخرین ویرایش: </label>
            <?= Jalali::date(Jalali::KHAN_SHORT, $model->update_time) ?>
        </p>
		<p>
			<label>زمان ساخت: </label>
            <?= Jalali::date(Jalali::KHAN_SHORT, $model->create_time) ?>
        </p>
		<p>
			<label>زمان پاک شدن: </label>
            <?= Jalali::date(Jalali::KHAN_SHORT, $model->delete_time) ?>
        </p>
	</div>
</div>
