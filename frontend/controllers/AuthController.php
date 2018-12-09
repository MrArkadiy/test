<?php

namespace frontend\controllers;

use project\account\forms\LoginForm;
use project\account\LoginAccountServices;
use Yii;

class AuthController extends AppController
{

    private $_login_account_services;

    public function __construct(string $id, $module, LoginAccountServices $login_account_services,  array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_login_account_services = $login_account_services;
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->post()){
            $account = $this->_login_account_services->login(Yii::$app->request->post());
            if ($account &&  Yii::$app->user->login($account)){
                return $this->goBack();
            }else{
                Yii::$app->getSession()->setFlash('error', $this->_login_account_services->errors);
            }
        }

        return $this->render('login', [
            'model' => new LoginForm(),
        ]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}