<?php
namespace khans\utils\rbac;

use yii\base\BaseObject;
use yii\rbac\CheckAccessInterface;
use yii\web\User;
use yii\di\Instance;

/**
 * Class AccessCheckerTable provides access cheker object for table based user identity
 *
 * @package khans\utils\rbac
 * @version 0.1.4-980314
 * @since 1.0
 */
class AccessCheckerTable extends BaseObject implements CheckAccessInterface
{

    public $userClass = '\khans\utils\models\UserTable';

    /**
     *
     * {@inheritdoc}
     * @see \yii\rbac\CheckAccessInterface::checkAccess()
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        $source = $this->getUserIdentity($userId);
//         $source = $this->getUser($userId);
        if ($source->getIsSuperAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Get user
     *
     * @return KHanUser
     */
    public function getUser($id): \khans\utils\models\KHanUser
    {
        if (\Yii::$app->user->id == $id) {
            return \Yii::$app->user;
        }
        return forward_static_call([
            $this->userClass,
            'findOne'
        ], $id);
    }

    /**
     * Get user
     *
     * @return UserTable
     */
    public function getUserIdentity($id): \khans\utils\models\UserTable
    {
        if (\Yii::$app->user->id == $id) {
            return \Yii::$app->user->identity;
        }
        return forward_static_call([
            $this->userClass,
            'findOne'
        ], $id);
    }
}