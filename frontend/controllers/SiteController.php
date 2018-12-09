<?php

namespace frontend\controllers;

use project\account\AccountServices;
use project\bonus\BonusServices;

use project\payments\Payment;
use Yii;


/**
 * Site controller
 */
class SiteController extends AppController
{

    private $_bonus_services;
    private $_payment;
    private $_bonus_repository;
    private $_account;

    public function __construct(string $id, $module, AccountServices $account, BonusServices $bonus_services, Payment $payment, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_account = $account;
        $this->_bonus_services = $bonus_services;
        $this->_payment = $payment;
        $this->_bonus_repository = $bonus_services->repository;

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

    function actionGetBonus()
    {
        try {
            $bonus = $this->_bonus_services->getRandomBonus();
            $insert_bonus = $this->_bonus_repository->insertBonus($this->_account->getId(), $bonus->value, $bonus->type);
            $messages = $this->renderPartial('partials/' . strtolower($bonus->type), ['bonus' => $bonus, 'id' => $insert_bonus->id]);
            return $this->render('get-bonus', ['messages' => $messages]);
        } catch (\Exception $e) {
            return $this->render('error', ['exception' => $e]);
        }
    }

    function actionCancelBonus($id)
    {
        try {
            $bonus = $this->_bonus_repository->getById($id);
            $bonus->cancelBonus();
            Yii::$app->session->setFlash('success', 'Бонус отменен. Вы приняли верное решение.');
            $this->redirect('/');
        } catch (\Exception $e) {
            return $this->render('error', ['exception' => $e]);
        }
    }

    function actionDepositPoints($id)
    {
        try {
            $bonus = $this->_bonus_repository->getById($id);
            $this->_account->upBalance((int)$bonus->value);
            $bonus->receiveBonus();
            Yii::$app->session->setFlash('success', 'Бонус зачислен.');
            $this->redirect('/');
        } catch (\Exception $e) {
            return $this->render('error', ['exception' => $e]);
        }
    }

    function actionWithdrawBank($id)
    {
        try{
            $bonus = $this->_bonus_repository->getById($id);
            $this->_payment->withdraw->bank()->forBonus()->newTransaction($this->_account->getId(), $bonus->value);
            Yii::$app->session->setFlash('success', 'Отлично. Запрос отправлен в обработку.');
            $this->redirect('/');
        }catch (\Exception $e){
            return $this->render('error', ['exception' => $e]);
        }

    }

    function actionConvertInPoints($id)
    {
        try {
            $coefficient = 3;
            $bonus = $this->_bonus_repository->getById($id);
            $amount = $this->_bonus_services->convertMoneyToPoints($bonus->value, $coefficient);
            $this->_account->upBalance($amount);
            $bonus->receiveBonus();
            Yii::$app->session->setFlash('success', 'Баллы зачислены! Коэффициент x'.$coefficient.'.');
            $this->redirect('/');
        } catch (\Exception $e) {
            return $this->render('error', ['exception' => $e]);
        }
    }

    function actionDeliveryBonus()
    {
        Yii::$app->session->setFlash('success', 'Мы рекомендовали отказаться. Но вы не послушались. К вам уже выехали, теперь нет пути назад.');
        $this->redirect('/');
    }


}
