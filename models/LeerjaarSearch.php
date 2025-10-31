<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leerjaar;

/**
 * LeerjaarSearch represents the model behind the search form about `app\models\Leerjaar`.
 */
class LeerjaarSearch extends Leerjaar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leerjaar_id'], 'integer'],
            [['naam'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Leerjaar::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'leerjaar_id' => $this->leerjaar_id,
        ]);

        $query->andFilterWhere(['like', 'naam', $this->naam]);

        return $dataProvider;
    }
}
