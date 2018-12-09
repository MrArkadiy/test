<?php

namespace project\account\repository;


use project\account\exceptions\AccountExceptions;
use project\account\forms\SingUpForm;
use yii\db\ActiveRecord;


/**
 * AccountRepositoryAR
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property int $balance
 * @property string $password_hash
 *
 */
class AccountRepositoryAR extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%accounts}}';
    }

    /**
     * @param $username
     * @param $email
     * @param $balance
     * @param $password_hash
     * @return null|AccountRepositoryAR
     */
    function newAccount($username, $email, $balance, $password_hash)
    {
        $newAccount = new self();
        $newAccount->username = $username;
        $newAccount->email = $email;
        $newAccount->balance = $balance;
        $newAccount->password_hash = $password_hash;
        return $newAccount->save() ? $newAccount : null;
    }

    /**
     * @param $id
     * @return null|AccountRepositoryAR
     * @throws AccountExceptions
     */
    function getById($id)
    {
        $account = self::findOne($id);
        if (empty($account)){
            throw new AccountExceptions('Account no exist');
        }
        return $account;
    }

    /**
     * @param $username
     * @return null|AccountRepositoryAR
     * @throws AccountExceptions
     */
    function findByUserName($username)
    {
        $account = self::findOne(['username' => $username]);
        if (empty($account)){
            throw new AccountExceptions('Account no exist');
        }
        return $account;
    }

    /**
     * @param int $amount
     * @throws AccountExceptions
     */
    function upBalance(int $amount){
        $this->balance += $amount;
        if (!$this->save()){
            throw new AccountExceptions('Error set balance');
        }
    }

    /**
     * @param int $amount
     * @throws AccountExceptions
     */
    function downBalance(int $amount){
        $this->balance -= $amount;
        if (!$this->save()){
            throw new AccountExceptions('Error set balance');
        }
    }

}