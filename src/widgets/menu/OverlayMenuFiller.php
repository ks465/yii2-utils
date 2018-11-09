<?php
/**
 * @package   app\widgets\menu
 * @author    Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version   0.1.0-970717
 */


namespace KHanS\Utils\widgets\menu;


use KHanS\Utils\components\FileHelper;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * Class OverlayMenuFiller reads a CSV file and builds the menu items required for [[OverlayMenu]].
 * You do not need to call this class directly, instead you can configure [[OverlayMenu]] to utilize it.
 *
 * **Example 1**
 *
 * ```php
 * $this->menuFiller = new OverlayMenuFiller([
 *    'csvFileUrl' => 'sample.csv',
 *    'tabs' => $this->tabs,
 * ]);
 * ```
 *
 * **Example 2**
 *
 * ```php
 * $this->menuFiller = new OverlayMenuFiller([
 *    'csvFileUrl' => 'sample.csv',
 *    'tabs' => $this->tabs,
 * ]);
 * '''
 *
 * @see       OverlayMenu
 * @see       sample.csv
 * @package   app\widgets\menu
 * @author    Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version   0.1.0-970717
 */
class OverlayMenuFiller extends BaseObject
{
    /**
     * @var string Full path to CSV file
     * Full path to a CSV file containing the data required for rendering menu.
     * see [Overlay Menu Guide](guide:widgets-menu.md#subsection)
     */
    public $csvFileUrl = '';
    /**
     * List of tabs and view parameters
     *
     * @var array
     */
    public $tabs = [];
    /**
     * Data ready for rendering the menu
     *
     * @var array
     */
    private $menuData = [];

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function init()
    {
        if (empty($this->csvFileUrl)) {
            throw new \Exception('CSV file is mandatory.');
        }
        $this->csvFileUrl = \Yii::getAlias($this->csvFileUrl);
        if (!file_exists($this->csvFileUrl)) {
            throw new \Exception('File not found: ' . $this->csvFileUrl);
        }
        $this->menuData = FileHelper::loadCSV($this->csvFileUrl, true);

        if (empty($this->tabs)) {
            $this->generateTabsData();
        } else {
            $this->compileData();
        }

        parent::init();
    }

    /**
     * Shape data for output very simple.
     * When [[tabs]] data is not present, build it from menu data.
     */
    private function generateTabsData()
    {
        foreach (ArrayHelper::map($this->menuData, 'url', function($item) {
            return $item;
        }, 'tab') as $id => $items) {

            if (!array_key_exists($id, $this->tabs)) {
                $this->tabs[$id] = [
                    'id'    => $id,
                    'title' => ucwords($id),
                    'icon'  => '',
                    'admin' => false,
                    'items' => $items,
                ];
            }

        }
    }

    /**
     * Build data as user requested.
     * If any of the tab-names in the CSV file is not present in the [[tabs]], It would drop.
     */
    private function compileData()
    {
        foreach ($this->menuData as $item) {
            $key = $item['tab'] ? : 'empty';

            if (!array_key_exists($key, $this->tabs)) {
                continue;
            }

            if (!array_key_exists('items', $this->tabs[$key])) {
                $this->tabs[$key]['items'] = [];
            }
            $this->tabs[$key]['items'][$item['url']] = $item;
        }
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        return $this->tabs;
    }
}