<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * operatorSearch represents the model behind the search form of `common\models\User`.
 */
class OperatorSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'user_chat_id', 'step', 'status_new', 'status_being_delivered', 'status_delivered', 'status_returned', 'status_black_list', 'status_then_takes', 'status_ready_to_delivery', 'status_hold', 'status_preparing'], 'integer'],
            [['username', 'first_name', 'last_name', 'tell', 'card', 'occupation', 'about', 'url', 'filename', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'code', 'access_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
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
        $query = User::find()->joinWith('assignment')->where(['auth_assignment.item_name' => 'operator'])->orWhere(['auth_assignment.item_name' => 'operator_returned']);

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_chat_id' => $this->user_chat_id,
            'step' => $this->step,
            'status_new' => $this->status_new,
            'status_being_delivered' => $this->status_being_delivered,
            'status_delivered' => $this->status_delivered,
            'status_returned' => $this->status_returned,
            'status_black_list' => $this->status_black_list,
            'status_then_takes' => $this->status_then_takes,
            'status_ready_to_delivery' => $this->status_ready_to_delivery,
            'status_hold' => $this->status_hold,
            'status_preparing' => $this->status_preparing,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'tell', $this->tell])
            ->andFilterWhere(['like', 'card', $this->card])
            ->andFilterWhere(['like', 'occupation', $this->occupation])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'access_token', $this->access_token]);

        return $dataProvider;
    }
}
