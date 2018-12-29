<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\controller\Generator */

echo "<?php\n";
?>


namespace <?= $generator->getControllerNamespace() ?>;

/**
* <?= $controllerClass ?> implements something.
*
* @package khans\utils\generatedControllers
* @version 0.0.1-970908
* @since   1.0
*/
class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
<?php foreach ($generator->getActionIDs() as $action): ?>
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }

<?php endforeach; ?>
}
