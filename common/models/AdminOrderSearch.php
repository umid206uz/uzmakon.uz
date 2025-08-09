<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdminOrdersPaySearch represents the model behind the search form of `common\models\AdminOrders`.
 */
class AdminOrderSearch extends AdminOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'admin_id', 'amount', 'status'], 'integer'],
            [['created_date', 'payed_date', 'debit'], 'safe'],
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
     * @param integer $admin_id
     *
     * @return ActiveDataProvider
     */
    public function search($params, $admin_id)
    {
        $query = AdminOrders::find()->where(['admin_id' => $admin_id])->orderBy(['id' => SORT_DESC]);

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
            'admin_id' => $this->admin_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'debit' => $this->debit,
        ]);

        if ($this->created_date != '') {
            $query->andFilterWhere(['between', 'created_date', strtotime($this->created_date), strtotime($this->created_date) + 3600 * 24]);
        }

        if ($this->payed_date != '') {
            $query->andFilterWhere(['between', 'payed_date', strtotime($this->payed_date), strtotime($this->payed_date) + 3600 * 24]);
        }

        return $dataProvider;
    }
}
