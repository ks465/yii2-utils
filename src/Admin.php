<?php


namespace KHanS\Utils;

use KHanS\Utils\components\HulkHtmlVarDumpTheme;
use KHanS\Utils\components\SqlFormatter;
use KHanS\Utils\components\VarDump;
use KHanS\Utils\components\VarDumpTheme;
use yii\base\BaseObject;
use yii\base\NotSupportedException;
use yii\db\Query;


/**
 * Class Admin contains methods to make life easier and fun for the admins.
 * It is also a wrapper for all utilities for debugging.
 *
 * @package KHanS\Utils
 * @version 0.2.0-970818
 * @since 1.0 */
class Admin extends BaseObject
{
    /**
     * Check to ensure that only superAdmin is allowed to use this module
     *
     * @throws NotSupportedException
     */
    public static function permit()
    {
        if(\Yii::$app->user->hasMethod('isSuperAdmin') && \Yii::$app->user->isSuperAdmin){
            return true;
        }
        throw new NotSupportedException('This method is not defined in this context.');
    }
    /**
     * Count online users by checking last modified time of session files.
     *
     * Make sure session save path is accessible.
     * If the counting idle time has passed, it may drop the current user in counting.
     *
     * @return bool|int
     */
    public static function who()
    {
//        self::permit();
        $path = session_save_path();

        if (!is_readable($path)) {
            return false;
        }
        if (trim($path) == "") {
            return false;
        }
        $d = dir($path);
        $i = 0;
        while (false !== ($entry = $d->read())) {
            if ($entry != "." and $entry != "..") {
                if (time() - filemtime($path . "/$entry") < Settings::MAX_IDLE_TIME) {
                    $i++;
                }
            }
        }
        $d->close();

        return $i;
    }
    /**
     * Shortcut to dump one or more variables for debug purposes
     *
     * @return void
     */
    public static function vd()
    {
        $varDump = new VarDump(null, null, null, new HulkHtmlVarDumpTheme());
        $variables = func_get_args();
        foreach ($variables as $variable) {
            $varDump->dump($variable);
        }
    }

    /**
     * Shortcut to dump one or more variables for debug purposes. This function will stop your script after the dump.
     *
     * @return void
     */
    public static function vdd($variables)
    {
        call_user_func_array(['KHanS\Utils\Admin', 'vd'], func_get_args());
        exit;
    }

    /**
     * Shortcut to dump a single variable for debug purposes. This function will stop your script after the dump.
     *
     * @param mixed        $variable Variable to print
     * @param integer      $recursiveDepth Maximum level of recursiveness
     * @param integer      $stringLength Maximum length for the preview of a string
     * @param boolean      $includeMethods Flag to see if object methods should be included
     * @param VarDumpTheme $theme Theme for the output
     *
     * @return void
     */
    public static function vdcd($variable, $recursiveDepth = null, $stringLength = null, $includeMethods = null,
        VarDumpTheme $theme = null)
    {
        Admin::vdc($variable, $recursiveDepth, $stringLength, $includeMethods, $theme);

        exit;
    }

    /**
     * Shortcut to dump a single variable for debug purposes.
     *
     * @param mixed        $variable Variable to print
     * @param integer      $recursiveDepth Maximum level of recursiveness
     * @param integer      $stringLength Maximum length for the preview of a string
     * @param boolean      $includeMethods Flag to see if object methods should be included
     * @param VarDumpTheme $theme Theme for the output
     *
     * @return void
     */
    public static function vdc($variable, $recursiveDepth = null, $stringLength = null, $includeMethods = null,
        VarDumpTheme $theme = null)
    {
        $varDump = new VarDump($recursiveDepth, $stringLength, $includeMethods, $theme);
        $varDump->dump($variable);
    }

    /**
     * Show a formatted text of an SQL query.
     *
     * @param string|Query $query
     *
     * @return void
     */
    public static function sql($query)
    {
        echo '<p dir="ltr">' . Admin::getTrace() . '</p>';
        if (is_string($query)) {
            echo SqlFormatter::format($query);
        }
        if ($query instanceof Query) {
            echo SqlFormatter::format($query->createCommand()->rawSql);
        }
    }

    /**
     * Gets the trace of the call before this class
     *
     * @return string File name and line number
     */
    private static function getTrace()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        do {
            $caller = array_shift($backtrace);
            if (isset($caller['file']) && $caller['file'] !== __FILE__) {
                break;
            }
        } while ($caller);

        if (!$caller) {
            return null;
        }

        return $caller['file'] . ':' . $caller['line'];
    }

    /**
     * Show a formatted text of an SQL query. This function will stop your script after the dump.
     *
     * @param string|Query $query
     *
     * @return void
     */
    public static function sqld($query)
    {
        echo '<p dir="ltr">' . Admin::getTrace() . '</p>';
        if (is_string($query)) {
            echo SqlFormatter::format($query);
        }
        if ($query instanceof Query) {
            echo SqlFormatter::format($query->createCommand()->rawSql);
        }

        exit;
    }
}
