<?php


namespace project\account;


use project\account\forms\SingUpForm;
use project\account\identity\Identity;
use project\account\repository\AccountRepositoryAR;
use yii\web\IdentityInterface;

class SingUpAccountServices
{

    public $errors = [];
    private $_repository;


    public function __construct(AccountRepositoryAR $account_repository)
    {
        $this->_repository = $account_repository;
    }

    /**
     * @param $post
     * @return null|IdentityInterface
     * @throws \Exception
     */
    public function singUpAccount($post): ?IdentityInterface
    {
        if($form = $this->validateForm($post)){
            $account = $this->createAccount($form);
            return new Identity($account);
        }
        return null;
    }

    /**
     * @param SingUpForm $form
     * @return null|AccountRepositoryAR
     * @throws \Exception
     */
    private function createAccount(SingUpForm $form){
        $account = $this->_repository->newAccount($form->username, $form->email, 0, $form->password_hash);
        if (!$account){
            throw new \Exception('Error sing up account');
        }
        return $account;
    }

    /**
     * @param $post
     * @return bool|SingUpForm
     */
    private function validateForm($post){
        $form = new SingUpForm();
        if (!$form->load($post) || !$form->validate()) {
            $this->errors = $form->getErrorSummary('');
           return false;
        }
        $form->setPasswordHash();
        return $form;
    }

}