<?php


namespace project\payments\repository;


use project\payments\enum\PaymentsStatusEnum;
use project\payments\exceptions\PaymentExceptions;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property int $account_id
 * @property string $payment_for
 * @property string $amount
 * @property string $status
 * @property $datetime
 * @property string $method
 * @property string $payment_type
 */


class PaymentsRepositoryAR extends ActiveRecord
{
    static function tableName()
    {
        return "{{payments}}";
    }


    public function newTransaction($account_id, $amount, $payment_for, $payment_type, $method)
    {
       $transaction = new self();
       $transaction->account_id = $account_id;
       $transaction->amount = $amount;
       $transaction->payment_for = $payment_for;
       $transaction->payment_type = $payment_type;
       $transaction->method = $method;
       $transaction->datetime = date("Y-m-d H:i:s");
       $transaction->status = PaymentsStatusEnum::PAYMENT_STATUS_NEW;
        if (!$transaction->save()){
            throw new PaymentExceptions('Error crate new transaction');
        }

    }

    public function getAllNewWithdrawByPaymentFor($payment_for, $limit = false){
        $query = self::find()->where(['payment_for' => $payment_for, 'status' => PaymentsStatusEnum::PAYMENT_STATUS_NEW]);
        if ($limit){
            $query->limit($limit);
        }
        return $query->all();
    }

    public function statusDone(){
        $this->status = PaymentsStatusEnum::PAYMENT_STATUS_DONE;
        if (!$this->save()){
            throw new PaymentExceptions('Error change status');
        }
    }

}