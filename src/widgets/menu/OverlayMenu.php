<?php
/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 */


namespace KHanS\Utils\widgets\menu;

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
 * @package KHanS\Utils\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 * @since 1.0
 */
class OverlayMenu extends \yii\base\Widget
{
    /**
     * @var string Full path to a CSV file containing the data required for rendering menu
     */
    public $csvFileUrl = '';
    /**
     * List of tabs and view parameters
     *
     * @var array
     */
    public $tabs = [];
    /**
     * @var OverlayMenuAsset
     */
    private $bundle;
    /**
     * Label for the created button
     *
     * @var string
     */
    public $label = 'Offnen';
    /**
     * Title for the created view
     *
     * @var string
     */
    public $title = 'Menu';
    /**
     * Html tag used for rendering the launcher
     *
     * @var string
     */
    public $tag = 'a';
    /**
     * List of options passed to the created tag
     *
     * @var array
     */
    public $options = [];
    /**
     * Object to find and format menu items
     *
     * @var OverlayMenuFiller
     */
    private $menuFiller;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->menuFiller = new OverlayMenuFiller([
            'csvFileUrl' => $this->csvFileUrl,
            'tabs'       => $this->tabs,

        ]);
        $this->bundle = OverlayMenuAsset::register($this->getView());

        $this->options = array_merge($this->options, [
            'onCLick' => 'khanMenuOpenNav()',
        ]);

        parent::init();
    }

    public function run()
    {
        return $this->render('menu', ['title' => $this->title]);
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
     * @return OverlayMenuFiller
     */
    public function getMenu()
    {
        return $this->menuFiller;
    }
}


