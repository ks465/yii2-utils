<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 15:52
 */


namespace KHanS\Utils;


use yii\base\BaseObject;

/**
 * Class Settings
 *
 * @package KHanS\Utils
 * @version 0.1-970803
 * @since   1.0
 */
class Settings extends BaseObject
{
    /**
     * Cache lifetime
     */
    const CACHE_TIMEOUT = 1;

    /**
     * Date format for long detailed date-time
     */
    const DATE_LONG_DATE_TIME = 'Y/m/d H:i:s';
    /**
     * List of icons for navigation keys in the grid view pager
     *
     * @var array
     */
    private static $_pager;

    /**
     * @return array
     */
    public static function getPager()
    {
        return self::$_pager;
    }

    public function init()
    {
        Settings::$_pager = [
            'firstPageLabel' => '<i class="glyphicon glyphicon-fast-backward"> </i>',
            'prevPageLabel'  => '<i class="glyphicon glyphicon-chevron-left"> </i>',
            'nextPageLabel'  => '<i class="glyphicon glyphicon-chevron-right"> </i>',
            'lastPageLabel'  => '<i class="glyphicon glyphicon-fast-forward"> </i>',
            //'maxButtonCount' => 5,
        ];
    }

    /**
     * Path to application models repository, this is mainly used for [[AppBuilder]] to create new models.
     */
    const PATH_MODELS_DIRECTORY = '@app\\models';
}