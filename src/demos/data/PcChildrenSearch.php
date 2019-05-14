<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\PcChildren;
use khans\utils\demos\data\PcChildrenQuery;

/**
 * PcChildrenSearch represents the model behind the search form about `\khans\utils\demos\data\PcChildren`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class PcChildrenSearch extends PcChildren
{
    /**
     * @var \khans\utils\demos\data\PcChildrenQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = PcChildren::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'table_id', 'oci_length', 'reference_table', 'reference_field', 'order', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['oci_field', 'oci_type', 'maria_field', 'maria_format', 'label'], 'safe'],
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
            'table_id' => $this->table_id,
            'oci_length' => $this->oci_length,
            'reference_table' => $this->reference_table,
            'reference_field' => $this->reference_field,
            'order' => $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'is_applied' => $this->is_applied,
            'updated_by' => $this->updated_by,
        ]);

        $this->query->andFilterWhere(['like', 'oci_field', $this->oci_field])
            ->andFilterWhere(['like', 'oci_type', $this->oci_type])
            ->andFilterWhere(['like', 'maria_field', $this->maria_field])
            ->andFilterWhere(['like', 'maria_format', $this->maria_format])
            ->andFilterWhere(['like', 'label', $this->label]);


        return $dataProvider;
    }
}
