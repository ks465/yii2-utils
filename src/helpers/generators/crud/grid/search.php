<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();
$queryClass = get_class($generator->modelClass::find());

echo "<?php\n";
?>


namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
<?= $generator->enableEAV ? 'use khans\utils\tools\models\SysEavAttributes;' : '' ?>

use yii\data\ActiveDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;
use <?= $queryClass ?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $generator->modelClass ?>`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    /**
     * @var <?= $queryClass ?> centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()<?= $generator->enableEAV ? '->getEavJoinQuery()' : '' ?>;
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $this->query->where('0=1');
            return $dataProvider;
        }

        <?= implode("\n        ", $searchConditions) ?>

<?php if($generator->enableEAV): ?>
        foreach (SysEavAttributes::find()->where(['entity_table' => '<?= $generator->modelClass::tableName() ?>'])->all() as $field) {
            /* @var SysEavAttributes $field */
            if ($field->attr_type == 'number') {
                $this->query->andEavFilterCompare($field->attr_name, $this->{$field->attr_name});
            } elseif ($field->attr_type == 'string') {
                $this->query->andEavFilterCompare($field->attr_name, $this->{$field->attr_name}, 'like');
            } else {
                $this->query->andEavFilterWhere($field->attr_name, $this->{$field->attr_name});
            }
        }
<?php endif; ?>

        return $dataProvider;
    }
}
