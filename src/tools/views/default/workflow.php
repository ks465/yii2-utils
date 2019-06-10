<?php
/* @var $this yii\web\View */
/* @var $selectedWF string */
/* @var $files array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $testModel \khans\utils\models\KHanModel */
/* @var $showVisual boolean */
/* @var $defaultEmail string */

use yii\bootstrap\Html;
use \khans\utils\widgets\GridView;

$this->title = 'تعریف گردش کار';
$this->params['breadcrumbs'][] = ['label' => 'Admin Tools', 'url' => ['/khan']];

$this->params['breadcrumbs'][] = $this->title;

if (!$showVisual) {
    echo $this->render('wf-selector', ['files' => $files]);
    return;
}

raoul2000\workflow\view\WorkflowViewWidget::widget([
    'workflow'    => $testModel,
    'containerId' => 'workflow-container',
]);
?>
<div class="workflow-statuses-index">
    <h1>
        <?= Html::encode($this->title) ?>
        <?= $this->render('wf-selector', ['files' => $files, 'selectedWF' => $selectedWF]) ?>
    </h1>
    <h2>
        <?= $files[$selectedWF] ?>
        <sapn class="h3">رتبه آغازین ::
            <?= $testModel->getWorkflow()->getInitialStatus()->getLabel() ?>
            <small class="text-info">(<?= $testModel->getWorkflow()->getInitialStatusId() ?>)</small>
            </span>
    </h2>
    <?=
    GridView::widget([
        'dataProvider'       => $dataProvider,
        'title'              => $files[$selectedWF],
        'columns'            => require_once(__DIR__ . '/wf-columns.php'),
        'export'             => false,
        'showRefreshButtons' => false,
        'itemLabelSingle'    => 'گردش',
        'itemLabelPlural'    => 'گردش کار',
        'createAction'       => false,
        'footer'             => '<strong class="text-danger">*</strong>' .
        'متن پیش‌فرض ایمیل: ' .
        '<strong class="text-info">' . $defaultEmail . '</strong>',
    ]);
    ?>
</div>

<div id="workflow-container" class="well well-info" style="height: 600px;"></div>