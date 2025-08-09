<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pages;

/**
 * PagesSearch represents the model behind the search form of `common\models\Pages`.
 */
class PagesSearch extends Pages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'title_ru', 'title_en', 'url', 'url_ru', 'url_en', 'meta_title', 'meta_title_ru', 'meta_title_en', 'meta_description', 'meta_description_ru', 'meta_description_en'], 'safe'],
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
        $query = Pages::find()->orderBy(['id' => SORT_DESC]);

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

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_en', $this->title_en])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'url_ru', $this->url_ru])
            ->andFilterWhere(['like', 'url_en', $this->url_en])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_title_ru', $this->meta_title_ru])
            ->andFilterWhere(['like', 'meta_title_en', $this->meta_title_en])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru])
            ->andFilterWhere(['like', 'meta_description_en', $this->meta_description_en]);

        return $dataProvider;
    }
}
