<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vak".
 *
 * @property int $vak_id
 * @property string|null $vak
 */
class Vak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vak'], 'string', 'max' => 255],
            [['vak'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vak_id' => 'Vak ID',
            'vak' => 'Vak',
        ];
    }
}
