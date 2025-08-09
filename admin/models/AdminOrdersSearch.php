<?php

namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * AdminOrdersSearch represents the model behind the search form of `admin\models\AdminOrders`.
 */
class AdminOrdersSearch extends AdminOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'admin_id', 'amount', 'status', 'debit'], 'integer'],
            [['created_date', 'payed_date'], 'safe'],
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
        $query = AdminOrders::find()->where(['admin_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

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
            'amount' => $this->amount,
            'status' => $this->status,
            'debit' => $this->debit,
        ]);

        if ($this->created_date) {
            $query->andFilterWhere(['between', 'created_date', strtotime($this->created_date), strtotime($this->created_date) + 3600 * 24]);
        }

        if ($this->payed_date) {
            $query->andFilterWhere(['between', 'payed_date', strtotime($this->payed_date), strtotime($this->payed_date) + 3600 * 24]);
        }

        return $dataProvider;
    }
}
