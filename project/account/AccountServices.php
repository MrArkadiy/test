<?php

namespace project\account;


use project\account\interfaces\AccountInterface;
use project\account\repository\AccountRepositoryAR;

class AccountServices implements AccountInterface
{

    private $_repository;
    private $_account;


    public function __construct($user_id)
    {
        $this->_repository = new AccountRepositoryAR();
        if (!empty($user_id)){
            $this->_account = $this->_repository->getById($user_id);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_account->id;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->_account->username;
    }

    /**
     * @param int $amount
     * @throws exceptions\AccountExceptions
     */
    public function upBalance(int $amount)
    {
        $this->_account->upBalance($amount);
    }

    /**
     * @param int $amount
     * @throws exceptions\AccountExceptions
     */
    public function downBalance(int $amount)
    {
        return $this->_account->downBalance($amount);
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->_account->balance;
    }
}