<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $studentID
 * @property string|null $id_nummer
 * @property string|null $naam
 * @property string|null $voornaam
 * @property string|null $geslacht
 * @property string|null $geboorte_datum
 * @property string|null $geboorte_plaats
 * @property string|null $nationaliteit
 * @property string|null $beroepsprofiel
 * @property string|null $school_huidig
 * @property string|null $school_vorig
 * @property string|null $district_school_vorig
 * @property string|null $naam_ouders
 * @property string|null $adres_ouders
 * @property string|null $nummer_ouders
 * @property string|null $adres_student
 * @property string|null $woonplaats_student
 * @property string|null $district_woonplaats
 * @property string|null $nummer_student
 * @property string|null $huisarts
 * @property string|null $nummer_huisarts
 * @property resource|null $foto
 * @property string|null $opmerking
 * @property string|null $email_adres
 * @property string|null $etniciteit
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['naam_ouders', 'foto', 'opmerking'], 'string'],
            [['id_nummer', 'naam', 'voornaam', 'geslacht', 'geboorte_datum', 'geboorte_plaats', 'nationaliteit', 'beroepsprofiel', 'school_huidig', 'school_vorig', 'district_school_vorig', 'adres_ouders', 'nummer_ouders', 'adres_student', 'woonplaats_student', 'district_woonplaats', 'nummer_student', 'huisarts', 'nummer_huisarts', 'email_adres', 'etniciteit'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'studentID' => 'Student ID',
            'id_nummer' => 'Id Nummer',
            'naam' => 'Naam',
            'voornaam' => 'Voornaam',
            'geslacht' => 'Geslacht',
            'geboorte_datum' => 'Geboorte Datum',
            'geboorte_plaats' => 'Geboorte Plaats',
            'nationaliteit' => 'Nationaliteit',
            'beroepsprofiel' => 'Beroepsprofiel',
            'school_huidig' => 'School Huidig',
            'school_vorig' => 'School Vorig',
            'district_school_vorig' => 'District School Vorig',
            'naam_ouders' => 'Naam Ouders',
            'adres_ouders' => 'Adres Ouders',
            'nummer_ouders' => 'Nummer Ouders',
            'adres_student' => 'Adres Student',
            'woonplaats_student' => 'Woonplaats Student',
            'district_woonplaats' => 'District Woonplaats',
            'nummer_student' => 'Nummer Student',
            'huisarts' => 'Huisarts',
            'nummer_huisarts' => 'Nummer Huisarts',
            'foto' => 'Foto',
            'opmerking' => 'Opmerking',
            'email_adres' => 'Email Adres',
            'etniciteit' => 'Etniciteit',
        ];
    }
    public function getSchooljaar()
    {
        return $this->hasOne(Schooljaar::class, ['IDstudent' => 'studentID']);

    }
}
