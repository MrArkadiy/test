<?php

namespace frontend\controllers;

use project\account\forms\SingUpForm;
use project\account\identity\Identity;
use project\account\SingUpAccountServices;;
use Yii;

class SignupController extends AppController
{

    private $_sing_up_account_services;

    public function __construct(string $id, $module, SingUpAccountServices $sing_up_account_services,  array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_sing_up_account_services = $sing_up_account_services;
    }

    public function actionIndex()
    {
        if (Yii::$app->request->post()) {
            try{
                $account = $this->_sing_up_account_services->singUpAccount(Yii::$app->request->post());
                if ($account && Yii::$app->getUser()->login($account)){
                    return $this->goHome();
                }else{
                    Yii::$app->getSession()->setFlash('error', $this->_sing_up_account_services->errors);
                }
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }

        return $this->render('signup', [
            'model' => new SingUpForm(),
        ]);
    }

   /* public function actionIndex()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }*/

}