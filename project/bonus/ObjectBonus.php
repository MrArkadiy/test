<?php

namespace project\bonus;


use project\bonus\entities\ResultBonusEntity;
use project\bonus\exceptions\BonusExceptions;
use project\bonus\interfaces\BonusInterface;
use project\bonus\interfaces\LimitedBonusInterface;

class ObjectBonus implements BonusInterface, LimitedBonusInterface
{

    private $list;
    private $limit;

    public function __construct(BonusSettings $settings)
    {
        $this->list = $settings->getList();
        $this->limit = $settings->getLimit();
    }

    /**
     * @return mixed
     * @throws BonusExceptions
     */
    public function getBonus(): ResultBonusEntity
    {
        if (empty($this->list)){
            throw new BonusExceptions('Error get object bonus');
        }
        $object_key = array_rand($this->list, 1);
        $value = $this->list[$object_key];
        return new ResultBonusEntity($value, $this->getType());
    }


    function checkOverLimit($current_count)
    {
        return $current_count >= $this->limit;
    }

    public function getType()
    {
        return BonusInterface::TYPE_BONUS_OBJECT;
    }
}