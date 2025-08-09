<?php

namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CharityPaymentSearch represents the model behind the search form of `common\models\CharityPayment`.
 */
class CharityPaymentSearch extends CharityPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'count', 'amount'], 'integer'],
            [['created_date', 'payed_date'], 'safe']
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
        $query = CharityPayment::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

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
            'status' => $this->status,
            'count' => $this->count,
            'amount' => $this->amount
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
