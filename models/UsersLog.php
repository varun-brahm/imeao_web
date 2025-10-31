<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_log".
 *
 * @property int $id
 * @property string|null $opmerking
 * @property string|null $datum
 * @property int|null $uid
 */
class UsersLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datum'], 'safe'],
            [['uid'], 'integer'],
            [['opmerking'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Log #',
            'opmerking' => 'Activiteit',
            'datum' => 'Datum',
            'uid' => 'Gebruiker',
        ];
    }

    public function getGebruiker()
    {
        return $this->hasOne(Users::className(), ['id' => 'uid']);
    }
}
