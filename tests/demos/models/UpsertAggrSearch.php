<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 24/11/18
 * Time: 11:29
 */


namespace khans\utils\tests\demos\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class UpsertAggrSearch extends UpsertAggr
{
    public function rules()
    {
        return [
            [['grade', 'field', 'year', 'status', 'counter', 'r_a', 'r_b'], 'safe'],

        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UpsertAggr::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'field' => $this->field,
            'year' => $this->year,
            'status' => $this->status,
            'grade' => $this->grade,
        ]);

        return $dataProvider;
    }
}
