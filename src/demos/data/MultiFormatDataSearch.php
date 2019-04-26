<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\MultiFormatData;
use khans\utils\models\queries\KHanQuery;

/**
 * MultiFormatDataSearch represents the model behind the search form about `khans\utils\demos\data\MultiFormatData`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class MultiFormatDataSearch extends MultiFormatData
{
    /**
     * @var khans\utils\models\queries\KHanQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = MultiFormatData::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['pk_column', 'integer_column', 'timestamp_column', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
            [['text_column', 'progress_column'], 'string'],
            [['boolean_column'], 'boolean'],
            [['real_column'], 'safe'],
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
            'pk_column' => $this->pk_column,
            'integer_column' => $this->integer_column,
            'boolean_column' => $this->boolean_column,
            'timestamp_column' => $this->timestamp_column,
            'progress_column' => $this->progress_column,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $this->query->andFilterCompare('real_column', $this->real_column);

        $this->query->andFilterWhere(['like', 'text_column', $this->text_column]);

        return $dataProvider;
    }
}
