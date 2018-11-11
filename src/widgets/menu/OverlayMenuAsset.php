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
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     * A source asset file is a file that is part of your source code repository of your Web application.
     */
    public $sourcePath = '@khan/src/widgets/menu/assets';
    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[js]].
     *
     * Note that only a forward slash "/" should be used as directory separator.
     */
    public $css = [
        'menu.css',
    ];
    /**
     * @var array list of JavaScript files that this bundle contains. Each JavaScript file can be
     * specified in one of the following formats:
     * Note that only a forward slash "/" should be used as directory separator.
     */
    public $js = [
        'menu.js',
    ];
}
