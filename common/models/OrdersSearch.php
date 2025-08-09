<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `common\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public $myPageSize;
    public $price;

    public function rules()
    {
        return [
            [['id', 'control_id', 'status', 'user_id', 'operator_id', 'region_id', 'district_id', 'price'], 'integer'],
            [['addres', 'full_name', 'phone', 'delivery_time'], 'string', 'max' => 255],
            [['text', 'product_id', 'take_time', 'comment'], 'string'],
            [['myPageSize'],'safe']
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
    public function searchs($params)
    {
        $query = Orders::find()->where(['id' => $params]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5000,
            ],
        ]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Orders::find()->orderBy(['id' => SORT_DESC])->joinWith(['product']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->myPageSize,
            ],
        ]);



        $dataProvider->sort->attributes['product_id'] = [
            'asc' => ['product.title' => SORT_ASC],
            'desc' => ['product.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'orders.user_id' => $this->user_id,
            'operator_id' => $this->operator_id,
            'courier_id' => $this->courier_id,
            'region_id' => $this->region_id,
            'addres' => $this->addres,
            'orders.status' => $this->status,
            'orders.id' => $this->id,
        ]);

        if ($this->text != '') {
            $query->andFilterWhere(['between', 'text', strtotime($this->text), strtotime($this->text) + 3600 * 24]);
        }

        if ($this->take_time != '') {
            $query->andFilterWhere(['between', 'take_time', strtotime($this->take_time), strtotime($this->take_time) + 3600 * 24]);
        }

        if ($this->delivery_time != '') {
            $query->andFilterWhere(['between', 'delivery_time', strtotime($this->delivery_time), strtotime($this->delivery_time) + 3600 * 24]);
        }

        if ($this->myPageSize !== null) {
            $dataProvider->pagination->pageSize = ($this->myPageSize !== NULL) ? $this->myPageSize : 20;
        }

        if ($this->full_name !== null) {
            $query->andFilterWhere(['like', 'full_name', $this->full_name]);
        }
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere(['like', 'addres', $this->addres]);
        $query->andFilterWhere(['like', 'product.title', $this->product_id]);
        $query->andFilterWhere(['like', 'product.sale', $this->price]);

        return $dataProvider;
    }
}
