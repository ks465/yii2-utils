<?php


namespace khans\utils\components\rest_v2;

use yii\base\Model;

/**
 * Class RestSearchModel simulates a typical search model for REST data sources
 *
 * @package khans\utils\components\rest_v2
 */
class RestSearchModel extends Model
{
    /**
     * @var RestQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = new RestQuery();
        }
        parent::init();
//$this->setAttributes(array_fill_keys( $this->query->select, null), false);
    }

    public function attributes()
    {
        return $this->query->select;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
[$this->query->select, 'safe']
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
     * @return RestDataProvider
     */
    public function search($params): RestDataProvider
    {
        $dataProvider = new RestDataProvider([
            'query' => $this->query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $this->query->where('0=1');
            return $dataProvider;
        }

        $this->query->andFilterWhere([

        ]);


        return $dataProvider;
    }
}