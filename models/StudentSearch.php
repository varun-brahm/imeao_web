<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Student;

/**
 * StudentSearch represents the model behind the search form about `app\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studentID'], 'integer'],
            [['id_nummer', 'naam', 'voornaam', 'geslacht', 'geboorte_datum', 'geboorte_plaats', 'nationaliteit', 'beroepsprofiel', 'school_huidig', 'school_vorig', 'district_school_vorig', 'naam_ouders', 'adres_ouders', 'nummer_ouders', 'adres_student', 'woonplaats_student', 'district_woonplaats', 'nummer_student', 'huisarts', 'nummer_huisarts', 'foto', 'opmerking', 'email_adres', 'etniciteit'], 'safe'],
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
        $query = Student::find();

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
            'studentID' => $this->studentID,
        ]);

        $query->andFilterWhere(['like', 'id_nummer', $this->id_nummer])
            ->andFilterWhere(['like', 'naam', $this->naam])
            ->andFilterWhere(['like', 'voornaam', $this->voornaam])
            ->andFilterWhere(['like', 'geslacht', $this->geslacht])
            ->andFilterWhere(['like', 'geboorte_datum', $this->geboorte_datum])
            ->andFilterWhere(['like', 'geboorte_plaats', $this->geboorte_plaats])
            ->andFilterWhere(['like', 'nationaliteit', $this->nationaliteit])
            ->andFilterWhere(['like', 'beroepsprofiel', $this->beroepsprofiel])
            ->andFilterWhere(['like', 'school_huidig', $this->school_huidig])
            ->andFilterWhere(['like', 'school_vorig', $this->school_vorig])
            ->andFilterWhere(['like', 'district_school_vorig', $this->district_school_vorig])
            ->andFilterWhere(['like', 'naam_ouders', $this->naam_ouders])
            ->andFilterWhere(['like', 'adres_ouders', $this->adres_ouders])
            ->andFilterWhere(['like', 'nummer_ouders', $this->nummer_ouders])
            ->andFilterWhere(['like', 'adres_student', $this->adres_student])
            ->andFilterWhere(['like', 'woonplaats_student', $this->woonplaats_student])
            ->andFilterWhere(['like', 'district_woonplaats', $this->district_woonplaats])
            ->andFilterWhere(['like', 'nummer_student', $this->nummer_student])
            ->andFilterWhere(['like', 'huisarts', $this->huisarts])
            ->andFilterWhere(['like', 'nummer_huisarts', $this->nummer_huisarts])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'opmerking', $this->opmerking])
            ->andFilterWhere(['like', 'email_adres', $this->email_adres])
            ->andFilterWhere(['like', 'etniciteit', $this->etniciteit]);

        return $dataProvider;
    }
}
