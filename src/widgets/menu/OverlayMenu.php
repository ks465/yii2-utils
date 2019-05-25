<?php
/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright khans 2018
 * @version 0.2.0-980304
 */


namespace khans\utils\widgets\menu;

use khans\utils\components\StringHelper;
use yii\helpers\{Html, Url};

/**
 * Class OverlayMenu creates an overlay menu
 *
 * **Example ** use in the navigation bar:
 *
 * ```php
 * NavBar::begin([
 *    'brandLabel' => Yii::$app->name,
 *    'brandUrl' => Yii::$app->homeUrl,
 *    'options' => [
 *       'class' => 'navbar-inverse navbar-fixed-top',
 *    ],
 * ]);
 * echo Nav::widget([
 *    'options' => ['class' => 'navbar-nav navbar-right'],
 *    'items' => [
 *       '<li>' . \app\widgets\menu\OverlayMenu::widget([
 *          'label' => 'menu',
 *          'csvFileUrl' => '@app/commands/menu-contents.csv',
 *          'options' => ['class' => 'btn btn-danger', 'style' => 'color:yellow;']
 *       ]) . '</li>',
 *       ['label' => 'Home', 'url' => ['/site/index']],
 *       ['label' => 'About', 'url' => ['/site/about']],
 *       ['label' => 'Contact', 'url' => ['/site/contact']],
 *    ],
 * ]);
 * NavBar::end();
 * ```
 *
 * **Example use in page**
 *
 * ```php
 * echo * \app\widgets\menu\OverlayMenu::widget([
 *    'label' => 'منوی همگانی سامانه‌ها',
 *    'tag' => 'button',
 *    'csvFileUrl' => '@app/commands/menu-contents.csv',
 *    'options' => ['class' => 'btn btn-danger'],
 *    'tabs' => [
 *       'general' => [
 *          'id' => 'general',
 *          'title' => 'همگانی',
 *          'icon' => 'heart',
 *          'admin' => false,
 *       ],
 *       'others' => [
 *          'id' => 'others',
 *          'title' => 'سایر',
 *          'icon' => 'user',
 *          'admin' => false,
 *       ],
 *    ],
 * ]);
 * ```
 *
 * See [OverlayMenu guide](guide:widgets-menu.md) for structure of the CSV file.
 *
 * @package khans\utils\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright khans 2018
 * @version 0.2.0-980304
 * @since 1.0
 */
class OverlayMenu extends \yii\base\Widget
{

    /**
     *
     * @var string Full path to a CSV file containing the data required for rendering menu
     */
    public $csvFileUrl = '';

    /**
     *
     * @var array List of tabs and view parameters
     */
    public $tabs = [];

    /**
     *
     * @var string Label for the created button
     */
    public $label = 'Offnen';

    /**
     *
     * @var string Title for the created view
     */
    public $title = 'Menu';

    /**
     *
     * @var string Html tag used for rendering the launcher
     */
    public $tag = 'a';

    /**
     *
     * @var array List of options passed to the created tag
     */
    public $options = [];

    /**
     *
     * @var OverlayMenuAsset Asset bundle
     */
    private $bundle;

    /**
     *
     * @var OverlayMenuFiller Object to find and format menu items
     */
    private $menuFiller;

    /**
     *
     * @var string Name of the cache element
     */
    public static $cacheKey = 'cache_overlay_menu_items';

    /**
     * Build and configure the widget
     */
    public function init()
    {
        $this->menuFiller = new OverlayMenuFiller([
            'csvFileUrl' => $this->csvFileUrl,
            'tabs' => $this->tabs
        ]);
        $this->bundle = OverlayMenuAsset::register($this->getView());

        $this->options = array_merge($this->options, [
            'onCLick' => 'khanMenuOpenNav()'
        ]);

        parent::init();
    }

    /**
     * Render the widget
     *
     * @return string
     */
    public function run()
    {
        return $this->render('menu', [
            'title' => $this->title,
            'anchors' => $this->getLinkAnchors()
        ]);
    }

    /**
     * Build the menu and save the cache
     *
     * @return array
     */
    private function getLinkAnchors()
    {
        $links = \Yii::$app->cache->get(self::$cacheKey);
        if ($links === false) {
            $links = [];
            foreach ($this->getMenu()->getTabs() as $tabID => $tabData) {
                if (! array_key_exists('items', $tabData)) {
                    continue;
                }
                $links[$tabID] = [];

                foreach ($tabData['items'] as $index => $tabDatum) {
                    if (empty($tabDatum['class'])) {
                        $tabDatum['class'] = 'default';
                    }
                    $mainClass = 'well-sm text-center' . ' text-' . $tabDatum['class'];

                    if (StringHelper::startsWith($tabDatum['url'], 'http', false)) {
                        $target = '_blank';
                        $link = $tabDatum['url'];
                    } else {
                        $target = '_self';
                        $link = Url::to([
                            $tabDatum['url']
                        ]);
                    }
                    $links[$tabID][] = Html::a($tabDatum['title'], $link, [
                        'target' => $target,
                        'class' => $mainClass
                    ]);
                }
            }
            \Yii::$app->cache->set(self::$cacheKey, $links);
        }

        return $links;
    }

    /**
     * Get th URL to the published assets
     *
     * @return string
     */
    public function getBundleUrl()
    {
        return $this->bundle->baseUrl;
    }

    /**
     *
     * @return OverlayMenuFiller
     */
    public function getMenu()
    {
        return $this->menuFiller;
    }
}
