<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 08/03/19
 * Time: 19:50
 */


namespace khans\utils\rbac;


use yii\rbac\Item;
use yii\rbac\Rule;

/**
 * Class KHanRule is the base for all rules and provides common filtering algorithms
 *
 * @package khans\utils\rbac
 * @version 0.1.0-971217
 * @since 1.0.0
 */
class KHanRule extends Rule
{

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item       $item the role or permission that this rule is associated with
     * @param array      $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     *
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        echo '<div class="ltr h4 alert alert-info">' .
            'KHanRule {Base common rules} triggered for user:: ' . $user . ' with ' . count($params) . ' params and will do the common things.' .
            'However it is empty now.' . $this->name;
vd($item);
        echo '</div>';
var_dump(debug_backtrace());
vdd($this->name);
        return true;

//         if (Yii::$app->user->isSuperAdmin) {
//             return true;
//         }
}
}