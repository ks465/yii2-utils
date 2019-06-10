<?php


namespace khans\utils\demos\data;

use Yii;
use yii\base\Model;

use yii\data\ActiveDataProvider;
use khans\utils\demos\data\SysHistoryEmails;
use khans\utils\tools\models\queries\SysHistoryEmailsQuery;

/**
 * SysHistoryEmailsSearch represents the model behind the search form about `khans\utils\demos\data\SysHistoryEmails`.
 *
 * @package khans\utils\generatedControllers
 * @version 0.3.1-980212
 * @since   1.0
 */
class SysHistoryEmailsSearch extends SysHistoryEmails
{
    /**
     * @var khans\utils\tools\models\queries\SysHistoryEmailsQuery centralized query object for this search model
     */
    public $query;

    /**
     * Set the query for this model if it is not already set
     */
    public function init()
    {
        if (empty($this->query)) {
            $this->query = SysHistoryEmails::find();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'enqueue_timestamp'], 'integer'],
            [['responsible_model', 'responsible_record', 'workflow_transition', 'workflow_start', 'workflow_end', 'content', 'user_id', 'recipient_id', 'recipient_email', 'cc_receivers', 'attachments'], 'safe'],
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
     * @inheritdoc
     */
    public function behaviors(): array
    {
        // bypass behaviors() implementation in the parent class
        return [];
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
            'enqueue_timestamp' => $this->enqueue_timestamp,
        ]);

        $this->query->andFilterWhere(['like', 'responsible_model', $this->responsible_model])
        ->andFilterWhere(['like', 'responsible_record', $this->responsible_record])
        ->andFilterWhere(['like', 'workflow_transition', $this->workflow_transition])
        ->andFilterWhere(['like', 'workflow_start', $this->workflow_start])
        ->andFilterWhere(['like', 'workflow_end', $this->workflow_end])
        ->andFilterWhere(['like', 'content', $this->content])
        ->andFilterWhere(['like', 'user_id', $this->user_id])
        ->andFilterWhere(['like', 'recipient_id', $this->recipient_id])
        ->andFilterWhere(['like', 'recipient_email', $this->recipient_email])
        ->andFilterWhere(['like', 'cc_receivers', $this->cc_receivers])
        ->andFilterWhere(['like', 'attachments', $this->attachments]);


        return $dataProvider;
    }
}

