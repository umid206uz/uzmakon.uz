<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderLog;

/**
 * OrderLogSearch represents the model behind the search form of `common\models\OrderLog`.
 */
class OrderLogSearch extends OrderLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'user_id', 'admin_id', 'old_status', 'new_status'], 'integer'],
            [['time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = OrderLog::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'admin_id' => $this->admin_id,
            'old_status' => $this->old_status,
            'new_status' => $this->new_status,
        ]);

        $query->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }
}
