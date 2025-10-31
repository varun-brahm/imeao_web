<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $log_id
 * @property int|null $user_id
 * @property string|null $omschrijving
 * @property string|null $datum
 * @property int|null $target_id
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'target_id'], 'integer'],
            [['datum'], 'safe'],
            [['omschrijving'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'user_id' => 'User ID',
            'omschrijving' => 'Omschrijving',
            'datum' => 'Datum',
            'target_id' => 'Target ID',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }}
