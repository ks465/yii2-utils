<?php
/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $this ->context KHanS\Utils\widgets\menuOverlayMenu */

$baseUrl = $this->context->getBundleUrl();
$columns = floor(12 / count($this->context->getMenu()->getTabs()));

$html = '';
foreach ($this->context->getMenu()->getTabs() as $tabID => $tabData) {
    if (!array_key_exists('items', $tabData)) {
        continue;
    }
    $icon = empty($tabData['icon']) ? '<i class="glyphicon glyphicon-plus"></i>&nbsp;' :
        '<i class="glyphicon glyphicon-' . $tabData['icon'] . '"></i>&nbsp;';

    $html .= '<div class="' . $tabID . ' col-md-' . $columns . '">' . PHP_EOL;
    $html .= '<h4 class="text-info">' . $icon . $tabData['title'] . '</h4>' . PHP_EOL;
    foreach ($tabData['items'] as $index => $tabDatum) {
        if (empty($tabDatum['class'])) {
            $tabDatum['class'] = 'default';
        }
        $mainClass = 'well-sm text-center' . ' text-' . $tabDatum['class'];

        $link = $tabDatum['title'];
        $html .= Html::a($link, $tabDatum['url'], ['target' => '_blank', 'class' => $mainClass]);
    }
    $html .= '</div>' . PHP_EOL;
}

?>
<!-- The overlay -->
<div id="KHanOverlayMenu" class="overlay center-block text-center">
    <!-- Button to close the overlay navigation -->
    <p class="h3">
        <a href="javascript:void(0)" class="closebtn" onclick="khanMenuCloseNav()">&times;</a>
        <?= $this->context->title ?>
    </p>
    <!-- Overlay content -->
    <div class="overlay-content">
        <?= $html ?>
    </div>
</div>
<!-- Use any element to open/show the overlay navigation menu -->
<?= \yii\helpers\Html::tag($this->context->tag, $this->context->label, $this->context->options) ?>
