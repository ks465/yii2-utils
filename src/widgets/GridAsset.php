<?php


namespace khans\utils\widgets;

use yii\web\AssetBundle;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0
 */
class GridAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@khan/src/widgets/assets';

    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[\khans\utils\widgets\GridAsset\js]].
     */
    public $css = [
        'AjaxModal.css',
    ];

    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];

    /**
     * Initializes the bundle.
     * If you override this method, make sure you call the parent implementation in the last.
     */
    public function init()
    {
        // In dev mode use non-minified javascripts
        $this->js = YII_DEBUG ? [
            'ModalRemote.js',
            'AjaxModal.js',
        ] : [
            'ModalRemote.min.js',
            'AjaxModal.min.js',
        ];

        parent::init();
    }
}
