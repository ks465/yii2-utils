<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 23/12/18
 * Time: 18:54
 */


namespace khans\utils\widgets;


use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Class KHDropDown accepts a simpler configuration array for creating a [[\kartik\dropdown\DropdownX]]
 *
 * @package khans\utils\widgets
 * @version 0.1.2-971008
 * @since 1.0
 */
class DropdownX extends \kartik\dropdown\DropdownX
{

    /**
     * @var array required configuration for the links to act as bulk action button
     */
    private $linkOptions = [
        'class'                => 'text-link btn-default',
        'role'                 => 'modal-remote-bulk',
        'data-confirm'         => false, // for override default confirmation
        'data-method'          => false, // for override yii data api
        'data-request-method'  => 'post',
        'data-confirm-title'   => ' آیا اطمینان دارید؟',
        'data-confirm-message' => 'این فرایند قابل برگشت نیست.',
    ];

    /**
     * ‌Build complete configuration for the parent class
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->items)) {
            throw new InvalidConfigException('فهرست منو الزامی است.');
        }

        $this->items = $this->setupItems($this->items);
        Html::addCssClass($this->options, ['widget' => 'dropdown-menu dropdown-menu-right']);

        parent::init();
    }

    private function setupItems($items)
    {
        foreach ($items as &$item) {
            if (is_array($item)) {
                $item['linkOptions'] = $this->linkOptions;

                if (isset($item['class'])) {
                    $item['linkOptions']['class'] = 'text-link btn-' . $item['class'];
                }
                $item['linkOptions']['data-confirm-title'] = $item['label'];
                if (isset($item['message'])) {
                    $item['linkOptions']['data-confirm-message'] = $item['message'];
                }

                if (isset($item['items'])) {
                    $item['items'] = $this->setupItems($item['items']);
                    $item['linkOptions']['style'] = 'box-shadow:none;'; //remove wrong shadow from submenus
                }
            }
        }

        return $items;
    }
}

