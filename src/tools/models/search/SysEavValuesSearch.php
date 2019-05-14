<?php


namespace khans\utils\tools\models\search;

use khans\utils\tools\models\SysEavValues;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * SysEavValuesSearch represents the model behind the search form of `khans\utils\tools\models\SysEavValues`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.3-980219
 * @since   1.0
 */
class SysEavValuesSearch extends SysEavValues
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
