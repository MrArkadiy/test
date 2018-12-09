<?php

namespace console\controllers;


use project\payments\enum\PaymentsForEnum;
use yii\console\Controller;
use project\payments\Payment;

class PaymentWithdrawController extends Controller
{



    function actionBonus(){

        $payments = new Payment();
        $limit = 1;
        $transactions = $payments->repository->getAllNewWithdrawByPaymentFor(PaymentsForEnum::PAYMENT_FOR_BONUS, $limit);
        //....


        foreach ($transactions as $transaction){
            //....
            $transaction->statusDone();
        }


    }

}