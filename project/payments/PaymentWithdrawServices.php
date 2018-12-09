<?php


namespace project\payments;


use project\payments\enum\PaymentsForEnum;
use project\payments\enum\PaymentsMethodEnum;
use project\payments\enum\PaymentsTypeEnum;
use project\payments\interfaces\PaymentsInterfaces;
use project\payments\repository\PaymentsRepositoryAR;

class PaymentWithdrawServices
{

    private $repository;
    private $method;
    private $payment_for;


    public function __construct(PaymentsRepositoryAR $repository)
    {
        $this->repository = $repository;
    }

    public function forBonus(){
        $this->payment_for = PaymentsForEnum::PAYMENT_FOR_BONUS;
        return $this;
    }

    public function bank(){
        $this->method = PaymentsMethodEnum::BANK;
        return $this;
    }

    public function newTransaction($account_id, $amount){
        $this->repository->newTransaction($account_id, $amount, $this->payment_for, PaymentsTypeEnum::PAYMENT_TYPE_WITHDRAW, $this->method);
    }

    public function applyTransaction($id, PaymentsInterfaces $method){
        //TODO - implement  applyTransaction($id) method;
        //$method->apply();
        return true;
    }




}