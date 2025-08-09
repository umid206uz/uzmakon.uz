<?php

namespace admin\models;

use common\models\Oqim;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StreamSearch represents the model behind the search form of `admin\models\Stream`.
 */
class StreamSearch extends Oqim
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'link'], 'integer'],
            [['title', 'key'], 'safe'],
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
        $query = Stream::find()->where(['user_id' => Yii::$app->user->id]);

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
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'link' => $this->link
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
