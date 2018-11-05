<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 21/09/18
 * Time: 10:31
 */


namespace KHanS\Utils\components;


use yii\base\BaseObject;

class MathHelper extends BaseObject
{
    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step   the step to round into
     *
     * @return float
     */
    public static function floorBy($number, $step = 0.5)
    {
        if (is_null($step)) {
            $step = 0.5;
        }

        return $step * floor($number / $step);
    }

    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step   the step to round into
     *
     * @return float
     */
    public static function ceilBy($number, $step = 0.5)
    {
        if (is_null($step)) {
            $step = 0.5;
        }

        return $step * ceil($number / $step);
    }
}