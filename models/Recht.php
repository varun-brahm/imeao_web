<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recht".
 *
 * @property int $recht_id
 * @property string|null $naam
 * @property int|null $cijfer
 * @property int|null $student_cijfer
 * @property int|null $school_cijfer
 * @property int|null $moederlijst_cijfer
 * @property int|null $student
 * @property int|null $student_student
 * @property int|null $user
 * @property int|null $user_user
 * @property int|null $user_recht
 * @property int|null $update_all
 */
class Recht extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recht';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['naam'], 'required'],
            [['cijfer', 'student_cijfer', 'school_cijfer', 'moederlijst_cijfer', 'student', 'student_student', 'user', 'user_user', 'user_recht','update_all'], 'integer'],
            [['naam'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recht_id' => 'Recht ID',
            'naam' => 'Naam',
            'cijfer' => 'Cijfer',
            'student_cijfer' => 'Student Cijfer',
            'school_cijfer' => 'School Cijfer',
            'moederlijst_cijfer' => 'Moederlijst Cijfer',
            'student' => 'Student',
            'student_student' => 'Student Student',
            'user' => 'User',
            'user_user' => 'User User',
            'user_recht' => 'User Recht',
            'update_all' => 'ALLES',
        ];
    }
}
