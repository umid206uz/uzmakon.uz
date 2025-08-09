<?php

namespace admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * PaymentSearch represents the model behind the search form of `admin\models\Payment`.
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Payment::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'amount' => $this->amount,
        ]);

        if ($this->payed_date) {
            $query->andFilterWhere(['between', 'payed_date', strtotime($this->payed_date), strtotime($this->payed_date) + 3600 * 24]);
        }

        if ($this->created_date) {
            $query->andFilterWhere(['between', 'created_date', strtotime($this->created_date), strtotime($this->created_date) + 3600 * 24]);
        }

        return $dataProvider;
    }
}
