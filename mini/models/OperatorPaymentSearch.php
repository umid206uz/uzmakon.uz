<?php

namespace mini\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OperatorPaymentSearch represents the model behind the search form of `mini\models\OperatorPayment`.
 */
class OperatorPaymentSearch extends OperatorPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'operator_id', 'amount', 'status'], 'integer'],
            [['created_date', 'payed_date'], 'safe'],
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
        $query = OperatorPayment::find()->orderBy(['id' => SORT_DESC])->where(['operator_id' => Yii::$app->user->id]);

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
            'amount' => $this->amount,
            'status' => $this->status,
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
