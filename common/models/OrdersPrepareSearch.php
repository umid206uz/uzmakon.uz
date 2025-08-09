<?php

namespace common\models;

use common\models\OrdersPrepare;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersPrepareSearch represents the model behind the search form of `common\models\OrdersPrepare`.
 */
class OrdersPrepareSearch extends OrdersPrepare
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'client_phone', 'admin_id', 'operator_id', 'courier_id', 'region_id', 'district_id', 'order_status', 'order_date', 'count', 'price', 'time', 'status'], 'integer'],
            [['product_name', 'client_name'], 'safe'],
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
        $query = OrdersPrepare::find()->where(['status' => 0]);

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
            'product_id' => $this->product_id,
            'client_phone' => $this->client_phone,
            'admin_id' => $this->admin_id,
            'operator_id' => $this->operator_id,
            'courier_id' => $this->courier_id,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'order_status' => $this->order_status,
            'order_date' => $this->order_date,
            'count' => $this->count,
            'price' => $this->price,
            'time' => $this->time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'client_name', $this->client_name]);

        return $dataProvider;
    }
}
