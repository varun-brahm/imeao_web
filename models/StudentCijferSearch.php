<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentCijfer;

/**
 * StudentcijferSearch represents the model behind the search form about `app\models\Studentcijfer`.
 */
class StudentCijferSearch extends StudentCijfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'klas_id', 'no'], 'integer'],
            [['naam', 'voornaam', 'm1t1', 'm1t2', 'm2t1', 'm2t2', 'm3t1', 'm3t2', 'm1h1', 'm1h2', 'm1h3', 'm1h4', 'm2h1', 'm2h2', 'm2h3', 'm2h4', 'm3h1', 'm3h2', 'm3h3', 'm3h4', 'gehaald', 'opmerking', 'voldoende', 'her1', 'her2', 'her3'], 'safe'],
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
        $query = Studentcijfer::find();

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
            'student_id' => $this->student_id,
            'klas_id' => $this->klas_id,
            'no' => $this->no,
        ]);

        $query->andFilterWhere(['like', 'naam', $this->naam])
            ->andFilterWhere(['like', 'voornaam', $this->voornaam])
            ->andFilterWhere(['like', 'm1t1', $this->m1t1])
            ->andFilterWhere(['like', 'm1t2', $this->m1t2])
            ->andFilterWhere(['like', 'm2t1', $this->m2t1])
            ->andFilterWhere(['like', 'm2t2', $this->m2t2])
            ->andFilterWhere(['like', 'm3t1', $this->m3t1])
            ->andFilterWhere(['like', 'm3t2', $this->m3t2])
            ->andFilterWhere(['like', 'm1h1', $this->m1h1])
            ->andFilterWhere(['like', 'm1h2', $this->m1h2])
            ->andFilterWhere(['like', 'm1h3', $this->m1h3])
            ->andFilterWhere(['like', 'm1h4', $this->m1h4])
            ->andFilterWhere(['like', 'm2h1', $this->m2h1])
            ->andFilterWhere(['like', 'm2h2', $this->m2h2])
            ->andFilterWhere(['like', 'm2h3', $this->m2h3])
            ->andFilterWhere(['like', 'm2h4', $this->m2h4])
            ->andFilterWhere(['like', 'm3h1', $this->m3h1])
            ->andFilterWhere(['like', 'm3h2', $this->m3h2])
            ->andFilterWhere(['like', 'm3h3', $this->m3h3])
            ->andFilterWhere(['like', 'm3h4', $this->m3h4])
            ->andFilterWhere(['like', 'gehaald', $this->gehaald])
            ->andFilterWhere(['like', 'opmerking', $this->opmerking])
            ->andFilterWhere(['like', 'voldoende', $this->voldoende])
            ->andFilterWhere(['like', 'her1', $this->her1])
            ->andFilterWhere(['like', 'her2', $this->her2])
            ->andFilterWhere(['like', 'her3', $this->her3]);

        return $dataProvider;
    }
}
