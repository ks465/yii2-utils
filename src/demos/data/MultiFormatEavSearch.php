<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;
use khans\utils\demos\data\SysEavAttributes;
use yii\data\ActiveDataProvider;
use khans\utils\demos\data\MultiFormatEav;
use khans\utils\demos\data\MultiFormatEavQuery;
use yii\db\ActiveRecord;

/**
 * MultiFormatEavSearch represents the model behind the search form about `khans\utils\demos\data\MultiFormatEav`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.2-980119
 * @since   1.0
 */
class MultiFormatEavSearch extends MultiFormatEav
{
    /**
     * @var \khans\utils\demos\data\MultiFormatEavQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = MultiFormatEav::find()->getEavJoinQuery();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['pk_column', 'integer_column', 'boolean_column', 'timestamp_column', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['text_column', 'progress_column'], 'safe'],
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
            'boolean_column' => $this->boolean_column,
            'timestamp_column' => $this->timestamp_column,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $this->query->andFilterWhere(['like', 'text_column', $this->text_column])
            ->andFilterWhere(['like', 'progress_column', $this->progress_column])
            ->andFilterCompare('real_column', $this->real_column)
            ->andFilterCompare('integer_column', $this->integer_column)
        ;

        foreach (SysEavAttributes::find()->where(['entity_table' => 'multi_format_data'])->all() as $field) {
            /* @var SysEavAttributes $field */
            if ($field->attr_type == SysEavAttributes::DATA_TYPE_NUMBER) {
                $this->query->andEavFilterCompare($field->attr_name, $this->{$field->attr_name});
            } elseif ($field->attr_type == SysEavAttributes::DATA_TYPE_BOOLEAN) {
                $this->query->andEavFilterCompare($field->attr_name,$this->{$field->attr_name});
            } elseif ($field->attr_type == SysEavAttributes::DATA_TYPE_STRING) {
                $this->query->andEavFilterCompare($field->attr_name, $this->{$field->attr_name}, 'like');
            } else {
                $this->query->andEavFilterWhere($field->attr_name, $this->{$field->attr_name});
            }
        }

        return $dataProvider;
    }
}
