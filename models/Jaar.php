<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jaar".
 *
 * @property int $jaar_id
 * @property string|null $naam
 */
class Jaar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jaar';
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
            'jaar_id' => 'Jaar ID',
            'naam' => 'Naam',
        ];
    }
}
