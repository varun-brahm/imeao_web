<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "klas".
 *
 * @property int $klas_id
 * @property string|null $naam
 * @property string|null $schooljaar
 * @property int|null $klassevoogd_id
 */
class Klas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klassevoogd_id'], 'integer'],
            [['naam', 'schooljaar'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'klas_id' => 'Klas ID',
            'naam' => 'Naam',
            'schooljaar' => 'Schooljaar',
            'klassevoogd_id' => 'Klassevoogd ID',
        ];
    }

    public function getDocent()
    {
        return $this->hasOne(Docent::class, ['docent_id' => 'klassevoogd_id']);
    }
}
