<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $name
 * @property int|null $users_type_id
 * @property int|null $active
 * @property string|null $auth_key
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int|null $ismaster
 * @property string|null $datumrec
 * @property int|null $recht_id
 * @property int|null $isdocent
 * /
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_type_id', 'username', 'password', 'name','recht_id'], 'required'],
            [['users_type_id', 'active', 'ismaster', 'recht_id', 'isdocent'], 'integer'],
            [['datumrec'], 'safe'],
            [['username', 'password'], 'string', 'max' => 125],
            [['name'], 'string', 'max' => 250],
            [['auth_key'], 'string', 'max' => 50],
            [['password_reset_token', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Gebruikersnaam',
            'password' => 'Wachtwoord',
            'name' => 'Naam',
            'users_type_id' => 'Gebruikers Type',
            'active' => 'Active',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'ismaster' => 'Ismaster',
            'datumrec' => 'Datumrec',
            'recht_id' => 'Recht ID',
            'isdocent' => 'Isdocent',
        ];
    }

    public function getUserType()
    {
        return $this->hasOne(UsersType::className(), ['id' => 'users_type_id']);
    }
}
