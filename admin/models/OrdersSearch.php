<?php

namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `admin\models\Orders`.
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
            [['id', 'control_id', 'status', 'user_id', 'operator_id', 'region_id', 'district_id'], 'integer'],
            [['addres', 'full_name', 'phone', 'delivery_time'], 'string', 'max' => 255],
            [['text', 'product_id'], 'string'],
            [['myPageSize', 'price'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
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

    public function search($params)
    {
        $query = Orders::find()->joinWith(['product'])->andWhere(['orders.user_id' => Yii::$app->user->id])->orderBy(['orders.id' => SORT_DESC]);

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
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'addres' => $this->addres,
            'orders.status' => $this->status,
            'orders.id' => $this->id,
        ]);

        if ($this->text != '') {
            $query->andFilterWhere(['between', 'text', strtotime($this->text), strtotime($this->text) + 3600 * 24]);
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
        $query->andFilterWhere(['like', 'product.title', $this->product_id]);

        return $dataProvider;
    }
}
