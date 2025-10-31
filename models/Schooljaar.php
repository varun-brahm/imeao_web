<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schooljaar".
 *
 * @property int $ID
 * @property int|null $IDstudent
 * @property string|null $schooljaar
 * @property string|null $huidige_klas
 * @property string|null $vorige_Klas
 * @property string|null $datum_inschrijving_her
 * @property int|null $stortingbewijs
 * @property resource|null $documenten_student
 * @property string|null $opmerking
 */
class Schooljaar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schooljaar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IDstudent', 'stortingbewijs'], 'integer'],
            [['datum_inschrijving_her'], 'safe'],
            [['documenten_student', 'opmerking'], 'string'],
            [['schooljaar', 'huidige_klas', 'vorige_Klas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'IDstudent' => 'I Dstudent',
            'schooljaar' => 'Schooljaar',
            'huidige_klas' => 'Huidige Klas',
            'vorige_Klas' => 'Vorige Klas',
            'datum_inschrijving_her' => 'Datum Inschrijving Her',
            'stortingbewijs' => 'Stortingbewijs',
            'documenten_student' => 'Documenten Student',
            'opmerking' => 'Opmerking',
        ];
    }
    public function getJaar()
    {
        return $this->hasOne(Jaar::class, ['jaar_id' => 'schooljaar']);
    }
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['studentID' => 'IDstudent']);
    }
}
