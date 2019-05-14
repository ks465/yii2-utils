<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\SysEavValues;
use khans\utils\demos\data\SysEavValuesQuery;

/**
 * SysEavValuesSearch represents the model behind the search form about `\khans\utils\demos\data\SysEavValues`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.3-980219
 * @since   1.0
 */
class SysEavValuesSearch extends SysEavValues
{
    /**
     * @var \khans\utils\demos\data\SysEavValuesQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = SysEavValues::find()->joinWith(['parent']);
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'attribute_id', 'record_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'safe'],
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
            'sys_eav_values.id' => $this->id,
            'attribute_id' => $this->attribute_id,
            'record_id' => $this->record_id,
            'status'     => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $this->query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
