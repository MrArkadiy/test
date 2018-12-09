<?php


namespace project\account;


use project\account\forms\LoginForm;
use project\account\identity\Identity;
use project\account\repository\AccountRepositoryAR;
use Yii;
use yii\web\IdentityInterface;

class LoginAccountServices
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
     * @throws exceptions\AccountExceptions
     */
    public function login($post): ?IdentityInterface{
        $form = $this->validateForm($post);
        $account = $this->_repository->findByUserName($form->username);
        if (!$account or !($identity = new Identity($account))->validatePassword($form->password)){
            $this->errors[] = 'Undefined user or password.';
            return null;
        }
        return $identity;
    }


    /**
     * @param $post
     * @return bool|LoginForm
     */
    private function validateForm($post){
        $form = new LoginForm();
        if (!$form->load($post) || !$form->validate()) {
            $this->errors = $form->getErrorSummary('');
            return false;
        }
        return $form;
    }

}