<?php

namespace app\components;

use app\models\User as UserModel;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    /**
     * @var UserModel
     */
    public $user;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = UserModel::findOne($id);
        return $user ? new static(['user' => $user]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = UserModel::findOne(['access_token' => $token]);
        return $user ? new static(['user' => $user]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user ? $this->user->id : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }
}