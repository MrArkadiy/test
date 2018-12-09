<?php

namespace frontend\controllers;

use project\account\AccountServices;


/**
 * Site controller
 */
class SiteController extends AppController
{


    private $_account;

    public function __construct(string $id, $module, AccountServices $account, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_account = $account;

    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['account' => $this->_account]);
    }


}
