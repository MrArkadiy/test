<?php


namespace project\account\identity;


use project\account\repository\AccountRepositoryAR;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{

    private $user;

    public function __construct(AccountRepositoryAR $user)
    {
        $this->user = $user;
    }


    /**
     * @param int|string $id
     * @return null|Identity|IdentityInterface
     */
    public static function findIdentity($id)
    {
        $account = AccountRepositoryAR::findOne($id);
        return $account ? new self($account) : null;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->user->password_hash);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->user->id;
    }

    /**
     * @param $token
     * @param null $type
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return string|void
     * @throws NotSupportedException
     */
    public function getAuthKey()
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    /**
     * @param string $authKey
     * @return bool|void
     * @throws NotSupportedException
     */
    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}