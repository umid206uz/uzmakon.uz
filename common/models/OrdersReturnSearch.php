<?php

namespace common\models;

use common\models\OrdersReturn;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersReturnSearch represents the model behind the search form of `common\models\OrdersReturn`.
 */
class OrdersReturnSearch extends OrdersReturn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'new_order_id', 'product_id', 'operator_id', 'admin_id', 'region_id', 'district_id', 'price', 'status'], 'integer'],
            [['customer_name', 'customer_phone', 'address', 'comment', 'created_date', 'order_date'], 'safe'],
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
        $query = OrdersReturn::find()->orderBy(['id' => SORT_DESC]);

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
            'new_order_id' => $this->new_order_id,
            'product_id' => $this->product_id,
            'operator_id' => $this->operator_id,
            'admin_id' => $this->admin_id,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        if ($this->order_date) {
            $query->andFilterWhere(['between', 'order_date', strtotime($this->order_date), strtotime($this->order_date) + 3600 * 24]);
        }

        if ($this->created_date != '') {
            $query->andFilterWhere(['between', 'created_date', strtotime($this->created_date), strtotime($this->created_date) + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
