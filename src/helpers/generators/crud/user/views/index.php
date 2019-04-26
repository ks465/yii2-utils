<?php
/**
 * This is the template for generating a User CRUD index view file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.1-971013
 * @since   1.0
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
echo "<?php\n";
?>
use yii\helpers\Url;
use yii\helpers\Html;
use khans\utils\widgets\GridView;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'کاربران::' . <?= $generator->generateString($generator->tableTitle) ?>;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <?="<?="?>GridView::widget([
            'id'                 => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-pjax',
            'dataProvider'       => $dataProvider,
            'filterModel'        => $searchModel,
            'columns'            => require(__DIR__.'/_columns.php'),
            'export'             => true,
            'showRefreshButtons' => true,
            'itemLabelSingle'    => 'کاربر',
            'itemLabelPlural'    => 'کاربران',
            'bulkAction'         => [
                'action'  => 'bulk-delete',
                'label'   => 'پاک‌کن',
                'icon'    => 'trash',
                'class'   => 'btn btn-danger btn-xs',
                'message' => 'آیا اطمینان دارید همه را پاک کنید؟',
                'hint'    => 'همه ' . <?= $generator->generateString($generator->tableTitle) ?> . ' انتخاب شده را',
            ],
            'createAction'       => [
                'ajax'    => true,
            ],
        ])<?="?>\n"?>
</div>
