<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\School;

/**
 * SchoolSearch represents the model behind the search form about `app\models\School`.
 */
class SchoolSearch extends School
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schooljaar_id', 'klas_id', 'schoolid', 'leerjaar_id', 'vak_id'], 'integer'],
            [['mentor', 'Klas', 'Vakdocent'], 'safe'],
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
        $query = School::find();

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
            'klas_id' => $this->klas_id,
            'schoolid' => $this->schoolid,
            'leerjaar_id' => $this->leerjaar_id,
            'vak_id' => $this->vak_id,
            'schooljaar_id'=> $this->schooljaar_id
        ]);

        $query
            ->andFilterWhere(['like', 'mentor', $this->mentor])
            ->andFilterWhere(['like', 'Klas', $this->Klas])
            ->andFilterWhere(['like', 'Vakdocent', $this->Vakdocent]);

        return $dataProvider;
    }
}
