<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studentcijfer".
 *
 * @property int $student_id
 * @property int|null $klas_id
 * @property int|null $no
 * @property string|null $naam
 * @property string|null $voornaam
 * @property string|null $m1t1
 * @property string|null $m1t2
 * @property string|null $m2t1
 * @property string|null $m2t2
 * @property string|null $m3t1
 * @property string|null $m3t2
 * @property string|null $m1h1
 * @property string|null $m1h2
 * @property string|null $m1h3
 * @property string|null $m1h4
 * @property string|null $m2h1
 * @property string|null $m2h2
 * @property string|null $m2h3
 * @property string|null $m2h4
 * @property string|null $m3h1
 * @property string|null $m3h2
 * @property string|null $m3h3
 * @property string|null $m3h4
 * @property int|null $gehaald
 * @property string|null $opmerking
 * @property string|null $voldoende
 * @property string|null $her1
 * @property string|null $her2
 * @property string|null $her3
 */
class Studentcijfer extends \yii\db\ActiveRecord
{
    public $student;
    public $vak_id;
    public $file;
    public $rawData;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'studentcijfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klas_id', 'no', 'gehaald'], 'integer'],
            [['file'], 'file', 'extensions' => 'xls, xlsx, csv', 'skipOnEmpty' => true, 'on' => 'upload'],
            [['student','rawData'], 'safe'],
            [['opmerking', 'her1', 'her2', 'her3'], 'string'],
            [['naam', 'voornaam', 'm1t1', 'm1t2', 'm2t1', 'm2t2', 'm3t1', 'm3t2', 'm1h1', 'm1h2', 'm1h3', 'm1h4', 'm2h1', 'm2h2', 'm2h3', 'm2h4', 'm3h1', 'm3h2', 'm3h3', 'm3h4', 'voldoende'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'student_id' => 'Student ID',
            'klas_id' => 'Klas ID',
            'no' => 'No',
            'naam' => 'Naam',
            'voornaam' => 'Voornaam',
            'm1t1' => 'M1t1',
            'm1t2' => 'M1t2',
            'm2t1' => 'M2t1',
            'm2t2' => 'M2t2',
            'm3t1' => 'M3t1',
            'm3t2' => 'M3t2',
            'm1h1' => 'M1h1',
            'm1h2' => 'M1h2',
            'm1h3' => 'M1h3',
            'm1h4' => 'M1h4',
            'm2h1' => 'M2h1',
            'm2h2' => 'M2h2',
            'm2h3' => 'M2h3',
            'm2h4' => 'M2h4',
            'm3h1' => 'M3h1',
            'm3h2' => 'M3h2',
            'm3h3' => 'M3h3',
            'm3h4' => 'M3h4',
            'gehaald' => 'Gehaald',
            'opmerking' => 'Opmerking',
            'voldoende' => 'Voldoende',
            'her1' => 'Her1',
            'her2' => 'Her2',
            'her3' => 'Her3',
        ];
    }
    public function getKlas()
    {
        return $this->hasOne(School::class, ['klas_id' => 'klas_id']);
    }
}
