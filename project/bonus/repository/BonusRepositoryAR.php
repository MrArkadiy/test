<?php

namespace project\bonus\repository;



use project\bonus\exceptions\BonusExceptions;
use project\bonus\interfaces\BonusInterface;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property int $account_id
 * @property string $value
 * @property string $type
 * @property $datetime
 * @property string $status
 */

class BonusRepositoryAR extends ActiveRecord
{

    static function tableName()
    {
        return '{{bonus}}';
    }

    function getById($id)
    {
        $bonus = self::findOne($id);
        if (empty($bonus)){
            throw new BonusExceptions('Bonus no exist');
        }
        return $bonus;
    }

    function getByType($type)
    {
        return self::findOne(['type' => $type]);
    }

    function getCountByType($type)
    {
        return self::find()->where(['type' => $type])->count();
    }

    function getAllByStatus($status)
    {
        return self::find()->where(['status' => $status])->all();
    }

    function getAllByStatusAndType($status, $type)
    {
        return self::find()->where(['status' => $status, 'type' => $type])->all();
    }


    function cancelBonus(){
        $this->status = BonusInterface::STATUS_BONUS_CANCELLED;
        if (!$this->save()){
            throw new BonusExceptions('Error cancel bonus');
        }
    }

    function receiveBonus(){
        $this->status = BonusInterface::STATUS_BONUS_RECEIVED;
        if (!$this->save()){
            throw new BonusExceptions('Error receive bonus');
        }
    }

    function insertBonus($account_id, $value, $type)
    {
        $new = new self();

        $new->account_id = $account_id;
        $new->value = $value;
        $new->type = $type;
        $new->datetime = date("Y-m-d H:i:s");
        $new->status = BonusInterface::STATUS_BONUS_NEW;

        if (!$new->save()){
            throw new BonusExceptions('Error insert bonus');
        }

        return $new;
    }



}