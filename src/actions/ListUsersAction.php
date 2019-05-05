<?php


namespace khans\utils\actions;


use yii\base\Action;
use yii\web\Response;

/**
 * Class ListUsersAction searches the current database for list of users
 *
 * @package khans\utils\controllers
 * @version 0.1.0-980215
 * @since 1.0
 */
class ListUsersAction extends Action
{
    /**
     * @param string $q filtering value
     *
     * @return array
     */
    public function run($q)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];

        $className = \Yii::$app->user->identityClass::className();
        /* @var \khans\utils\models\queries\KHanQuery $query */
        $query = $className::find()
            ->where([
                'or',
                ['id'=>$q],
                ['like', 'username', $q],
                ['like', 'name', $q],
                ['like', 'family', $q],
            ])
            ->asArray();

        foreach ($query->all() as $user) {
            $out['results'][] = ['id' => $user['id'], 'text' => $user['name'] . ' ' . $user['family']];
        }

        return $out;
    }
}