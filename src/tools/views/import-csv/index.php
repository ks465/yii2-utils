<?php
/* @var $this yii\web\View */
/* @var $tablesAvailable array */
/* @var $id string */

/* @var $model \yii\base\DynamicModel */

use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = 'انتخاب شناسه پایگاه داده';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ?></h1>
<div id="import-csv-get-db" class="well col-md-4 col-md-offset-4">

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'connection')->textInput([
        'placeHolder' => 'Database Connection ID :: db', 'class' => 'ltr',
    ])->label('شناسه پایگاه داده') ?>

    <div class="form-group">
        <?= Html::submitButton('ادامه ...', ['class' => 'btn btn-success pull-left']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>