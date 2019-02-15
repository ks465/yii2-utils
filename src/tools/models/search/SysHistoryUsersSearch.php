<?php


namespace khans\utils\tools\models\search;

use khans\utils\tools\models\SysHistoryUsers;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * SysHistoryUsersSearch represents the model behind the search form of `khans\utils\tools\models\SysHistoryUsers`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971104
 * @since   1.0
 */
class SysHistoryUsersSearch extends SysHistoryUsers
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
            $this->query = SysHistoryUsers::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'timestamp', 'result', 'attempts'], 'integer'],
            [['username', 'date', 'time', 'ip', 'user_id', 'user_table'], 'safe'],
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
            'id'        => $this->id,
            'timestamp' => $this->timestamp,
            'result'    => $this->result,
            'attempts'  => $this->attempts,
        ]);

        $this->query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_table', $this->user_table]);

        return $dataProvider;
    }
}
