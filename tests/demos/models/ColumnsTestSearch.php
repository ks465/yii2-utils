<?php

namespace khans\utils\tests\demos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ColumnsTest;
use yii\db\ActiveQuery;

/**
 * ColumnsTestSearch represents the model behind the search form of `app\models\ColumnsTest`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971013
 * @since   1.0
 */
class ColumnsTestSearch extends ColumnsTest
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
        if(empty($this->query)){
            $this->query = ColumnsTest::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'boolean_column', 'tiny_column', 'enum_column', 'integer_date_column', 'related_column'], 'integer'],
            [['string_date_column', 'progress_column', 'string_column'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
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
    public function search($params)
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
            'boolean_column' => $this->boolean_column,
            'tiny_column' => $this->tiny_column,
            'enum_column' => $this->enum_column,
            'integer_date_column' => $this->integer_date_column,
            'related_column' => $this->related_column,
        ]);

        $this->query->andFilterWhere(['like', 'string_date_column', $this->string_date_column])
            ->andFilterWhere(['like', 'progress_column', $this->progress_column])
            ->andFilterWhere(['like', 'string_column', $this->string_column]);

        return $dataProvider;
    }
}
