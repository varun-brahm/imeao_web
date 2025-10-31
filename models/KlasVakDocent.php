<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "klas_vak_docent".
 *
 * @property int $klas_vak_docent_id
 * @property int|null $klas_id
 * @property int|null $vak_id
 * @property int|null $docent_id
 */
class KlasVakDocent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klas_vak_docent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klas_id', 'vak_id', 'docent_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'klas_vak_docent_id' => 'Klas Vak Docent ID',
            'klas_id' => 'Klas ID',
            'vak_id' => 'Vak ID',
            'docent_id' => 'Docent ID',
        ];
    }
}
