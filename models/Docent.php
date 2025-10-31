<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docent".
 *
 * @property int $docent_id
 * @property string|null $naam
 */
class Docent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docent';
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
            'docent_id' => 'Docent ID',
            'naam' => 'Naam',
        ];
    }
}
