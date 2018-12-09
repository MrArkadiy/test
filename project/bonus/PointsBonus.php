<?php

namespace project\bonus;


use project\bonus\entities\ResultBonusEntity;
use project\bonus\exceptions\BonusExceptions;
use project\bonus\interfaces\BonusInterface;

class PointsBonus implements BonusInterface
{

    private $min;
    private $max;

    public function __construct(BonusSettings $settings)
    {
        $this->min = $settings->getIntervalMin();
        $this->max = $settings->getIntervalMax();
    }

    /**
     * @return mixed
     * @throws BonusExceptions
     */
    public function getBonus(): ResultBonusEntity
    {
        if (!$this->validateValue()) {
            throw new BonusExceptions('Error get points bonus');
        }
        $value = rand($this->min, $this->max);
        return new ResultBonusEntity($value, $this->getType());
    }

    public function getType()
    {
        return BonusInterface::TYPE_BONUS_POINTS;
    }

    private function validateValue()
    {
        if (!is_int($this->min) || !is_int($this->max)) {
            return false;
        }elseif ($this->min < 0 && $this->max < 1 ){
            return false;
        }
        return true;
    }

}