<?php

use kartik\form\ActiveForm;
use khans\utils\components\Jalali;
use khans\utils\widgets\ConfirmButton;
use khans\utils\widgets\DateRangePicker;
use khans\utils\widgets\menu\OverlayMenu;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Available Components';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h2>
    <a href="<?= Url::to(['/demos/components']) ?>"><?= $this->title ?></a>
</h2>

<div class="panel panel-primary ltr">
    <div class="panel-heading">
        Components
    </div>
    <div class="panel-body">
         <span class="col-sm-3" title="Sample Overlay Menu Reading from Test File.">
            <?= OverlayMenu::widget([
                'title'      => 'General Menu',
                'label'      => 'Show Overlay Menu',
                'tag'        => 'button',
                'csvFileUrl' => __DIR__ . '/../../data/sample-menu.csv',
                'options'    => ['class' => 'btn btn-block'],
                'tabs'       => [
                    'general'    => [
                        'id'    => 'general',
                        'title' => 'General',
                        'icon'  => 'heart',
                        'admin' => false,
                    ],
                    'others'     => [
                        'id'    => 'others',
                        'title' => 'Others',
                        'icon'  => 'user',
                        'admin' => false,
                    ],
                    'management' => [
                        'id'    => 'management',
                        'title' => 'Manager',
                        'icon'  => 'alert',
                        'admin' => true,
                    ],
                ],
            ]) ?>
        </span>
        <span class="col-sm-3" title="Confirm Button with POST.">
            <?php
            $form = ActiveForm::begin([
                'id'     => 'form-a', //mandatory
                'action' => Url::to(['components/jalali']), //optional
            ]);

            echo ConfirmButton::widget([
                'formID'         => $form->id,
                'buttonLabel'    => 'Confirm Load POST',
                'buttonClass'    => 'btn btn-block',
                'title'          => 'Modal dialog title',
                'message'        => Html::tag('h3', 'Any tailored message' . '<br/>' .
                        'Which actually could be' .
                        'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
                'btnOKLabel'     => 'Click this to go ahead',
                'btnCancelLabel' => 'Click this to cancel and go back',
                'btnOKIcon'      => 'fire',
                'btnCancelIcon'  => 'time',
            ]);
            ActiveForm::end();
            ?>
        </span>
        <span class="col-sm-3" title="Confirm Button with AJAX.">
            <?php
            $form = ActiveForm::begin([
                'id'     => 'form-b', //mandatory
                'action' => Url::to(['grid-view/rename', 'id' => 0]), //optional
            ]);

            echo ConfirmButton::widget([
                'type'           => ConfirmButton::TYPE_PRIMARY,
                'formID'         => $form->id,
                'sendAjax'       => true,
                'buttonLabel'    => 'Confirm Load AJAX',
                'buttonClass'    => 'btn btn-block',
                'title'          => 'modal dialog title',
                'message'        => Html::tag('h3', 'Any tailored message' . '<br/>' .
                        'Which actually could be' .
                        'splitted on multiple lines.', ['style' => 'color: #d9534f']) . 'with HTML tags.',
                'btnOKLabel'     => 'Click this to go ahead',
                'btnCancelLabel' => 'Click this to cancel and go back',
                'btnOKIcon'      => 'fire',
                'btnCancelIcon'  => 'time',
            ]);
            ActiveForm::end();
            ?>
        </span>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['components/jalali']) ?>"
           title="Multiple Examples with Jalali Date Component.">
            Jalali Date Examples
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['components/date-picker']) ?>"
           title="Multiple Examples with Jalali Date Picker.">
            Jalali Date Picker
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['components/jwt']) ?>"
           title="JWT token.">
            JWT Token
        </a>
        <a class="btn btn-default col-sm-3" href="<?= Url::to(['components/rest-v2']) ?>"
           title="Rest Client for PostgREST.">
            REST Client 2
        </a>
    </div>
    <div class="panel-footer">
    </div>
</div>
<?=  DateRangePicker::widget([
    'id'        => 'attribute-one',
    'attribute' => 'from_date',
    'model'     => new DynamicModel(['from_date' => Jalali::date('Y/m/d', time())]),
    'options'   => [
        'minDate' => '1395/01/01',
        'maxDate' => '1398/12/29',
    ],
]);?>
