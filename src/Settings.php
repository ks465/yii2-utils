<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 20/09/18
 * Time: 15:52
 */


namespace khans\utils;


use yii\base\BaseObject;

/**
 * Class Settings
 *
 * @package khans\utils
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
     * Maximum time a connected user is idle in seconds.
     * After this amount of time the user is considered as logged out or disconnected.
     * This is primarily used for counting online users.
     */
    const MAX_IDLE_TIME = 300;
    /**
     * Path to application models repository, this is mainly used for [[helpers\AppBuilder]] to create new models.
     */
    const PATH_MODELS_DIRECTORY = '@app/models/';
    /**
     * List of icons for navigation keys in the grid view pager
     *
     * @var array
     */
    private static $_pager;
    private static $_testSetting = 1;

    /**
     * @return array
     */
    public static function getPager()
    {
        return self::$_pager;
    }

    /**
     * @return int
     */
    public static function getTestSetting()
    {
        return self::$_testSetting;
    }


//<editor-fold Desc="Setters">

    /**
     * @param int $testSetting
     */
    public static function setTestSetting($testSetting)
    {
        self::$_testSetting = $testSetting;
    }
//</editor-fold>
//<editor-fold Desc="Getters">

    /**
     * Setup required settings to default value.
     */
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
//</editor-fold>
}
