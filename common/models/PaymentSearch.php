<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * PaymentSearch represents the model behind the search form of `common\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'amount'], 'integer'],
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

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
        $query = Payment::find()->orderBy(['id' => SORT_DESC]);

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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'amount' => $this->amount,
        ]);

        if ($this->payed_date != '') {
            $query->andFilterWhere(['between', 'payed_date', strtotime($this->payed_date), strtotime($this->payed_date) + 3600 * 24]);
        }

        if ($this->created_date != '') {
            $query->andFilterWhere(['between', 'created_date', strtotime($this->created_date), strtotime($this->created_date) + 3600 * 24]);
        }

        return $dataProvider;
    }
}
