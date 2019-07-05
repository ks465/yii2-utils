<?php
namespace khans\utils\rbac;

use yii\rbac\CheckAccessInterface;
use yii\base\BaseObject;

/**
 * Class AccessCheckerArray provides access cheker object for array based user identity
 *
 * @package khans\utils\rbac
 * @version 0.1.3-980308
 * @since 1.0
 */
class AccessCheckerArray extends BaseObject implements CheckAccessInterface
{
    /**
     * {@inheritDoc}
     * @see \yii\rbac\CheckAccessInterface::checkAccess()
     */
    public function checkAccess($userId, $permissionName, $params = array())
    {
        if (\Yii::$app->get('user')->isGuest) {
            return false;
        }

        return true;
    }
}
