<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $authKey;
    public $accessToken;
    public $functie;
    public $ptuid;
    public $analistid;

    public $recht_id;

    public static function findIdentity($id)
    {
        //  return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = Users::findOne($id);
        if(!$user)
        {
            return null;
        }
        else
        {
            $user_info =
                [
                    'id' => $user->id,
                    'username' => $user->username,
                    'password' => $user->password,
                    'fullname' => $user->name,
                    'authKey' => $user->auth_key,
                    'accessToken' => $user->password_reset_token,
                    'functie' => $user->users_type_id,
                    'ptuid' => $user->ismaster,
                    'analistid' => $user->active,
                    'recht_id' => $user->recht_id,
                ];
            return new static($user_info);
        }
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByUsername($username,$password)
    {
        $user = Users::find()->where(['username'=>$username, 'password'=>$password, 'active'=>1])->one();
        if(!$user)
        {
            return null;
        }
        else
        {
            $user_info =
                [
                    'id' => $user->id,
                    'username' => $user->username,
                    'password' => $user->password,
                    'fullname' => $user->name,
                    'authKey' => $user->auth_key,
                    'accessToken' => $user->password_reset_token,
                    'functie' => $user->users_type_id,
                    'ptuid' => $user->ismaster,
                    'analistid' => $user->active,
                    'recht_id' => $user->recht_id,
                ];
            return new static($user_info);
        }
//
//        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findByUsernameAndPassword($username, $password)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                if(strcasecmp($user['password'], $password) === 0) {
                    return new static($user);
                }
            }
        }

        return null;
    }
}
