<?php
/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright khans 2018
 * @version 0.1.2-980305
 */

use yii\helpers\Html;
use khans\utils\components\StringHelper;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $this->context khans\utils\widgets\menuOverlayMenu */
/* @var $anchors array */

$baseUrl = $this->context->getBundleUrl();
$columns = floor(12 / count($this->context->getMenu()->getTabs()));

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
    <?php
    foreach ($this->context->getMenu()->getTabs() as $tabID => $tabData) {
        if (!array_key_exists('items', $tabData)) {
            continue;
        }
        $icon = empty($tabData['icon']) ? '<i class="glyphicon glyphicon-plus"></i>&nbsp;' :
        '<i class="glyphicon glyphicon-' . $tabData['icon'] . '"></i>&nbsp;';
    ?>
    	<div class="<?= $tabID ?> col-sm-4 col-md-2">
        <h4 class="text-info"><?= $icon . $tabData['title'] ?></h4>
			<?= implode(PHP_EOL,$anchors[$tabID]) ?>
        </div>
    <?php
        }
    ?>
    </div>
</div>
<!-- Use any element to open/show the overlay navigation menu -->
<?= \yii\helpers\Html::tag($this->context->tag, $this->context->label, $this->context->options) ?>
