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


namespace <?= StringHelper::dirname($generator->columnClass)?>;

use <?= $generator->targetModel ?>;
use khans\utils\columns\RelatedColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Show column in grid views for a related field to <?= StringHelper::basename($generator->targetModel) ?> along with required filter element.
 *
 * ```php
 * ...
 *[
 *   'class'     => '<?= $generator->columnClass ?>',
 *   'attribute' => 'parent_id', // field name in the child table referring to the related table
 *],
 * ...
 * ```
 *
 * The following code is equivalent to this <?= StringHelper::basename($generator->columnClass) ?>.
 *
 * ```php
 * ...
 *[
 *   'class'       => '\khans\utils\columns\RelatedColumn',
 *   'attribute'   => 'parent_id', // field name in the child table referring to the related table
 *   'targetModel' => '<?= $generator->targetModel ?>',
 *   'titleField'  => '<?= $generator->targetField ?>',
 *],
 * ...
 * ```
 *
 * @package common\widgets
 */
class <?= StringHelper::basename($generator->columnClass) ?> extends RelatedColumn
{
    /**
     * @inheritdoc
     */
    public $targetModel = '<?= $generator->targetModel ?>';
    /**
     * @inheritdoc
     */
    public $titleField = '<?= $generator->targetField ?>';
}
