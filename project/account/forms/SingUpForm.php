<?php

namespace project\account\forms;


use project\account\repository\AccountRepositoryAR;
use Yii;
use yii\base\Model;

class SingUpForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_hash;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => AccountRepositoryAR::className(), 'message' => 'Пользователь с таким логином уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => AccountRepositoryAR::className(), 'message' => 'Пользователь с таким email уже существует'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }


    /**
     * @throws \yii\base\Exception
     */
    function setPasswordHash()
    {
       $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
    }


}