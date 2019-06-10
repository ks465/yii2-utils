<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/01/19
 * Time: 09:24
 */

use khans\utils\components\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\component\Generator */

echo "<?php\n";
?>


namespace <?= StringHelper::dirname($generator->actionClass)?>;

use <?= $generator->targetModel ?>;
use yii\base\Action;
use yii\web\Response;


/**
* This is the action for supporting <?= StringHelper::basename($generator->targetModel) ?> search and selector widgets.
* The query for this action searches both the key column and title column for the given string.
*
* @package KHanS\Utils
* @version 0.1.0-971029
* @since   1.0
*/
class <?= StringHelper::basename($generator->targetModel) ?>Action extends Action
{
    /**
     * @param string $q filtering value
     *
     * @return array
     */
    public function run($q)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        $query = <?= StringHelper::basename($generator->targetModel) ?>::find()
            ->select(['id' => '<?= $generator->targetField ?>', 'title' => '<?= $generator->titleField ?>'])
            ->orWhere(['like', '<?= $generator->targetField ?>', $q])
            ->orWhere(['like', '<?= $generator->titleField ?>', $q])
            ->orderBy(['<?= $generator->titleField ?>' => SORT_ASC])
            ->asArray();
        $out['results'] = $query->all();

        return $out;
    }
}
