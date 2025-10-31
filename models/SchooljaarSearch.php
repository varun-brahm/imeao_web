<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Schooljaar;

/**
 * SchooljaarSearch represents the model behind the search form about `app\models\Schooljaar`.
 */
class SchooljaarSearch extends Schooljaar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'IDstudent'], 'integer'],
            [['schooljaar', 'huidige_klas', 'vorige_Klas', 'datum_inschrijving_her', 'stortingbewijs', 'documenten_student', 'opmerking'], 'safe'],
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
        $query = Schooljaar::find();

        // Group by huidige_klas
        $query->groupBy('huidige_klas');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['huidige_klas' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'IDstudent' => $this->IDstudent,
            'datum_inschrijving_her' => $this->datum_inschrijving_her,
        ]);

        $query->andFilterWhere(['like', 'schooljaar', $this->schooljaar])
            ->andFilterWhere(['like', 'huidige_klas', $this->huidige_klas])
            ->andFilterWhere(['like', 'vorige_Klas', $this->vorige_Klas])
            ->andFilterWhere(['like', 'stortingbewijs', $this->stortingbewijs])
            ->andFilterWhere(['like', 'documenten_student', $this->documenten_student])
            ->andFilterWhere(['like', 'opmerking', $this->opmerking]);

        return $dataProvider;
    }

}
