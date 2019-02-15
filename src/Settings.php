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
     * Path to application models repository, this is mainly used for [[\khans\utils\helpers\AppBuilder]] to create new
     * models.
     */
    const PATH_MODELS_DIRECTORY = '@app/models/';
    /**
     * Setting for [[QueryParamAuth::tokenParam]]
     */
    const REST_TOKEN_PARAM = 'access-token';
    /**
     * Address for the REST server used by the REST client
     * Be sure to end this with /
     */
    const REST_SERVER_URL = '/';
    /**
     * List of icons for navigation keys in the grid view pager
     *
     * @var array
     */
    private static $_pager;
    private static $_testSetting = 1;


//<editor-fold Desc="Setters">
    /**
     * @return array
     */
    public static function getPager()
    {
        return self::$_pager;
    }
//</editor-fold>

//<editor-fold Desc="Getters">
    /**
     * @return int
     */
    public static function getTestSetting()
    {
        return self::$_testSetting;
    }

    /**
     * @param int $testSetting
     */
    public static function setTestSetting($testSetting)
    {
        self::$_testSetting = $testSetting;
    }
//</editor-fold>

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
}
