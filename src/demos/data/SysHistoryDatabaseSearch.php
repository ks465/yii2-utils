<?php


namespace khans\utils\demos\data;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * SysHistoryDatabaseSearch represents the model behind the search form of
 * `khans\utils\demos\data\SysHistoryDatabase`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971104
 * @since   1.0
 */
class SysHistoryDatabaseSearch extends SysHistoryDatabase
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
            $this->query = SysHistoryDatabase::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'type'], 'integer'],
            [['user_id', 'date', 'table', 'field_name', 'field_id', 'old_value', 'new_value'], 'safe'],
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
            'id'   => $this->id,
            'date' => $this->date,
            'type' => $this->type,
        ]);

        $this->query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'table', $this->table])
            ->andFilterWhere(['like', 'field_name', $this->field_name])
            ->andFilterWhere(['like', 'field_id', $this->field_id])
            ->andFilterWhere(['like', 'old_value', $this->old_value])
            ->andFilterWhere(['like', 'new_value', $this->new_value]);

        return $dataProvider;
    }
}
