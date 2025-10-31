<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recht;

/**
 * RechtSearch represents the model behind the search form about `app\models\Recht`.
 */
class RechtSearch extends Recht
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recht_id', 'cijfer', 'student_cijfer', 'school_cijfer', 'moederlijst_cijfer', 'student', 'student_student', 'user', 'user_user', 'user_recht'], 'integer'],
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
        $query = Recht::find();

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
            'recht_id' => $this->recht_id,
            'cijfer' => $this->cijfer,
            'student_cijfer' => $this->student_cijfer,
            'school_cijfer' => $this->school_cijfer,
            'moederlijst_cijfer' => $this->moederlijst_cijfer,
            'student' => $this->student,
            'student_student' => $this->student_student,
            'user' => $this->user,
            'user_user' => $this->user_user,
            'user_recht' => $this->user_recht,
        ]);

        $query->andFilterWhere(['like', 'naam', $this->naam]);

        return $dataProvider;
    }
}
