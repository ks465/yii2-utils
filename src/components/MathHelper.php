<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 21/09/18
 * Time: 10:31
 */


namespace khans\utils\components;


use yii\base\BaseObject;

/**
 * Class MathHelper contains methods to do some mathematical routines easier.
 * For examples please see [Math Helper Guide](guide:components-math-helper.md)
 *
 *
 * @package khans\utils
 * @version 0.1.1-970803
 * @since   1.0
 */
class MathHelper extends BaseObject
{
    /**
     * Default value for stepping functions [[floorBy]] and [[ceilBy]]
     */
    const DEFAULT_STEP = 0.5;

    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step the step to round into
     *
     * @return float
     */
    public static function floorBy($number, $step = null)
    {
        if (is_null($step)) {
            $step = MathHelper::DEFAULT_STEP;
        }

        return $step * floor($number / $step);
    }

    /**
     * truncate input in steps and enforce the limit on it
     *
     * @param float $number the actual number
     * @param float $step the step to round into
     *
     * @return float
     */
    public static function ceilBy($number, $step = null)
    {
        if (is_null($step)) {
            $step = MathHelper::DEFAULT_STEP;
        }

        return $step * ceil($number / $step);
    }
}
