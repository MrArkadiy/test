<?php


namespace project\bonus;


use project\bonus\entities\ResultBonusEntity;
use project\bonus\exceptions\BonusExceptions;
use project\bonus\interfaces\BonusInterface;
use project\bonus\interfaces\LimitedBonusInterface;

class MoneyBonus implements BonusInterface, LimitedBonusInterface
{

    private $min;
    private $max;
    private $limit;

    public function __construct(BonusSettings $settings)
    {
        $this->min = $settings->getIntervalMin();
        $this->max = $settings->getIntervalMax();
        $this->limit = $settings->getLimit();
    }


    public function getBonus(): ResultBonusEntity
    {
        if (!$this->validateValue()) {
            throw new BonusExceptions('Error get money bonus');
        }
        $value = rand($this->min, $this->max);
        return new ResultBonusEntity($value, $this->getType());
    }


    private function validateValue()
    {
        if (!is_int($this->min) || !is_int($this->max)) {
            return false;
        } elseif ($this->min < 0 && $this->max < 1) {
            return false;
        }
        return true;
    }

    function checkOverLimit($current_count)
    {
       return $current_count >= $this->limit;
    }

    public function getType()
    {
       return BonusInterface::TYPE_BONUS_MONEY;
    }
}