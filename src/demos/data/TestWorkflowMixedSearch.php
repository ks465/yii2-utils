<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\TestWorkflowMixed;
use khans\utils\demos\data\TestWorkflowMixedQuery;

/**
 * TestWorkflowMixedSearch represents the model behind the search form about `khans\utils\demos\data\TestWorkflowMixed`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980212
 * @since   1.0
 */
class TestWorkflowMixedSearch extends TestWorkflowMixed
{
    /**
     * @var khans\utils\demos\data\TestWorkflowMixedQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = TestWorkflowMixed::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['title', 'workflow_status'], 'safe'],
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
     * @inheritdoc
     */
    public function behaviors(): array
    {
        // bypass behaviors() implementation in the parent class
        return [];
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

        $this->query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $this->query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'workflow_status', $this->workflow_status]);


        return $dataProvider;
    }
}
