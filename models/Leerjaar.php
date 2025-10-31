<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leerjaar".
 *
 * @property int $leerjaar_id
 * @property string|null $naam
 */
class Leerjaar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leerjaar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['naam'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'leerjaar_id' => 'Leerjaar ID',
            'naam' => 'Naam',
        ];
    }
}
