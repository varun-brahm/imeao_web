<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cijfer_klas".
 *
 * @property int $cijfer_klas_id
 * @property int|null $student_id
 * @property int|null $cijfer_id
 * @property int|null $klas_id
 */
class CijferKlas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cijfer_klas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'cijfer_id', 'klas_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cijfer_klas_id' => 'Cijfer Klas ID',
            'student_id' => 'Student ID',
            'cijfer_id' => 'Cijfer ID',
            'klas_id' => 'Klas ID',
        ];
    }
}
