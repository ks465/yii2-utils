<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\PcParents;
use khans\utils\demos\data\PcParentsQuery;

/**
 * PcParentsSearch represents the model behind the search form about `\khans\utils\demos\data\PcParents`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class PcParentsSearch extends PcParents
{
    /**
     * @var \khans\utils\demos\data\PcParentsQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = PcParents::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'order', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['oci_table', 'maria_table', 'maria_pk', 'comment'], 'safe'],
            [['is_applied'], 'boolean'],
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
            'id' => $this->id,
            'order' => $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'is_applied' => $this->is_applied,
            'updated_by' => $this->updated_by,
        ]);

        $this->query->andFilterWhere(['like', 'oci_table', $this->oci_table])
            ->andFilterWhere(['like', 'maria_table', $this->maria_table])
            ->andFilterWhere(['like', 'maria_pk', $this->maria_pk])
            ->andFilterWhere(['like', 'comment', $this->comment]);


        return $dataProvider;
    }
}
