<?php
/**
 * This is the template for generating an action view file.
 *
 * @package KHanS\Utils
 * @version 0.2.0-971020
 * @since   1.0
 */

use khans\utils\components\StringHelper;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

use <?= ltrim($generator->modelClass, '\\') ?>;

/**
 * This is the action for <?= basename($generator->viewName) ?> view file.
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
public function action<?= Inflector::id2camel(trim(basename($generator->viewName), '_')) ?>()
{
    $model = new <?= $modelClass ?><?= empty($generator->scenarioName) ? "()" : "(['scenario' => '{$generator->scenarioName}'])" ?>;

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    }

    return $this->render('<?= basename($generator->viewName) ?>', [
        'model' => $model,
    ]);
}
