<?php
/**
 * This is the template for generating a controller class file.
 *
 * @package KHanS\Utils
 * @version 0.2.0-971020
 * @since   1.0
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\controller\Generator */

echo "<?php\n";
?>


namespace <?= $generator->getControllerNamespace() ?>;

/**
* <?= StringHelper::basename($generator->controllerClass) ?> implements something.
*
* @package khans\utils\generatedControllers
* @version 0.1.0-971020
* @since   1.0
*/
class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
<?php foreach ($generator->getActionIDs() as $action): ?>
   /**
    * Action <?= $action ?>.
    *
    * @return mixed
    */
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }

<?php endforeach; ?>
}
