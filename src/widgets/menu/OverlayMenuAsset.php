<?php

/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 */

namespace KHanS\Utils\widgets\menu;

/**
 * Asset bundle for overlay menu
 *
 * @package KHanS\Utils\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 * @since 1.0
 */
class OverlayMenuAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@khan/src/widgets/menu/assets';

    public $css = [
        'menu.css',
    ];

    public $js = [
        'menu.js',
    ];
}
