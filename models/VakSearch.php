<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vak;

/**
 * VakSearch represents the model behind the search form about `app\models\Vak`.
 */
class VakSearch extends Vak
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vak_id'], 'integer'],
            [['vak'], 'safe'],
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
        $query = Vak::find();

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
            'vak_id' => $this->vak_id,
        ]);

        $query->andFilterWhere(['like', 'vak', $this->vak]);

        return $dataProvider;
    }
}
