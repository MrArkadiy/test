<?php


namespace project\payments;


use project\payments\repository\PaymentsRepositoryAR;

class Payment
{

    public $withdraw;
    public $deposit;
    public $repository;

    public function __construct()
    {
        $this->repository = new PaymentsRepositoryAR();
        $this->withdraw = new PaymentWithdrawServices($this->repository);
        $this->deposit = new PaymentDepositServices();
    }

}