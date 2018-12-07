<?php
/**
 * @package   app\widgets\menu
 * @author    Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright khans 2018
 * @version   0.1.0-970717
 */


namespace khans\utils\widgets\menu;


use khans\utils\components\FileHelper;
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
 * @copyright khans 2018
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
     * @var array
     * List of tabs and view parameters
     */
    public $tabs = [];
    /**
     * @var array
     * Data ready for rendering the menu
     */
    private $menuData = [];

    /**
     * @throws \Exception when the file name is empty or the file is not found.
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
    private function generateTabsData():void
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
