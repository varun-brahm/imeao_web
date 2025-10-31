<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leerjaar_vak".
 *
 * @property int $leerjaar_vak_id
 * @property int|null $leerjaar_id
 * @property int|null $vak_id
 */
class LeerjaarVak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leerjaar_vak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leerjaar_id', 'vak_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'leerjaar_vak_id' => 'Leerjaar Vak ID',
            'leerjaar_id' => 'Leerjaar',
            'vak_id' => 'Vak',
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
}
