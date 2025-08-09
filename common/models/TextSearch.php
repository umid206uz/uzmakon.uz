<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Text;

/**
 * TextSearch represents the model behind the search form of `common\models\Text`.
 */
class TextSearch extends Text
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title1', 'title1_ru', 'title2', 'title2_ru', 'text', 'text_ru'], 'safe'],
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
        $query = Text::find();

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
        ]);

        $query->andFilterWhere(['like', 'title1', $this->title1])
            ->andFilterWhere(['like', 'title1_ru', $this->title1_ru])
            ->andFilterWhere(['like', 'title2', $this->title2])
            ->andFilterWhere(['like', 'title2_ru', $this->title2_ru])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'text_ru', $this->text_ru]);

        return $dataProvider;
    }
}
