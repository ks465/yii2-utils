<?php


namespace khans\utils\tools\models\search;

use khans\utils\tools\models\SysEavAttributes;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * SysEavAttributesSearch represents the model behind the search form of `khans\utils\tools\models\SysEavAttributes`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class SysEavAttributesSearch extends SysEavAttributes
{
    /**
     * @var ActiveQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = SysEavAttributes::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['entity_table', 'attr_name', 'attr_label', 'attr_type', 'attr_length', 'attr_scenario'], 'safe'],
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

        $this->query->andFilterWhere([
            'id'         => $this->id,
            'status'     => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $this->query->andFilterWhere(['like', 'entity_table', $this->entity_table])
            ->andFilterWhere(['like', 'attr_name', $this->attr_name])
            ->andFilterWhere(['like', 'attr_label', $this->attr_label])
            ->andFilterWhere(['like', 'attr_type', $this->attr_type])
            ->andFilterWhere(['like', 'attr_length', $this->attr_length])
            ->andFilterWhere(['like', 'attr_scenario', $this->attr_scenario]);

        return $dataProvider;
    }
}
