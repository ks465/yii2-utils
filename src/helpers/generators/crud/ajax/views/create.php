<?php
/**
 * This is the template for generating a AJAX CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971013
 * @since   1.0
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

<?='if (!Yii::$app->request->isAjax) {'."\n" ?>
    $this->title = <?= $generator->generateString('افزودن به ' . $generator->tableTitle) ?>;
    $this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->tableTitle) ?>, 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
<?="}\n" ?>
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?='<?php if (!Yii::$app->request->isAjax) { ?>'."\n" ?>
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    <?="<?php } ?>\n" ?>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
