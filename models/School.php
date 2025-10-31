<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property int $klas_id
 * @property int|null $schoolid
 * @property int|null $leerjaar_id
 * @property string|null $schooljaar_id
 * @property string|null $mentor
 * @property int|null $vak_id
 * @property string|null $Klas
 * @property string|null $Vakdocent
 */
class School extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schooljaar_id','Klas','leerjaar_id','mentor'], 'required'],
            [['schoolid', 'leerjaar_id', 'vak_id','schooljaar_id'], 'integer'],
            [['mentor', 'Klas', 'Vakdocent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'klas_id' => 'Klas',
            'schoolid' => 'Schoolid',
            'leerjaar_id' => 'Leerjaar',
            'schooljaar_id' => 'Schooljaar',
            'mentor' => 'Mentor',
            'vak_id' => 'Vak',
            'Klas' => 'Klas',
            'Vakdocent' => 'Vakdocent',
        ];
    }
    public function getVak()
    {
        return $this->hasOne(Vak::class, ['vak_id' => 'vak_id']);
    }

    public function getLeerjaar()
    {
        return $this->hasOne(Leerjaar::class, ['leerjaar_id' => 'leerjaar_id']);
    }
    public function getSchooljaar()
    {
        return $this->hasOne(Jaar::class, ['jaar_id' => 'schooljaar_id']);
    }
    public function getDocent()
    {
        return $this->hasOne(Users::class, ['id' => 'Vakdocent']);
    }

}
