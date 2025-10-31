<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LeerjaarVak;

/**
 * LeerjaarVakSearch represents the model behind the search form of `app\models\LeerjaarVak`.
 */
class LeerjaarVakSearch extends LeerjaarVak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leerjaar_vak_id', 'leerjaar_id', 'vak_id'], 'integer'],
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
        $query = LeerjaarVak::find();

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
            'leerjaar_vak_id' => $this->leerjaar_vak_id,
            'leerjaar_id' => $this->leerjaar_id,
            'vak_id' => $this->vak_id,
        ]);

        return $dataProvider;
    }
}
