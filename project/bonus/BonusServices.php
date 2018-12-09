<?php
namespace project\bonus;



use project\bonus\entities\ResultBonusEntity;
use project\bonus\interfaces\BonusInterface;
use project\bonus\interfaces\LimitedBonusInterface;
use project\bonus\repository\BonusRepositoryAR;


class BonusServices
{

    public $repository;

    private $money_bonus;
    private $object_bonus;
    private $points_bonus;


    public function __construct()
    {
        $this->repository = new BonusRepositoryAR();
        $this->money_bonus = new MoneyBonus($this->_getSettingsMoneyBonus());
        $this->object_bonus = new ObjectBonus($this->_getSettingsObjectBonus());
        $this->points_bonus = new PointsBonus($this->_getSettingsPointsBonus());

    }

    public function getRandomBonus(): ResultBonusEntity {
        $typeBonus = $this->_getRandomTypeBonus();
        $bonus = $this->_getBonusByType($typeBonus);
        $result = $bonus->getBonus();
        return $result;
    }

    public function convertMoneyToPoints($amount, $coefficient): int{
        return $amount * $coefficient;
    }


    private function _getBonusByType($type): BonusInterface{
        $bonus = null;
        switch ($type){
            case BonusInterface::TYPE_BONUS_MONEY : $bonus = $this->money_bonus; break;
            case BonusInterface::TYPE_BONUS_OBJECT : $bonus = $this->object_bonus; break;
            case BonusInterface::TYPE_BONUS_POINTS : $bonus = $this->points_bonus; break;
        }
        return $bonus;
    }

    private function _getRandomTypeBonus(){
        $listBonusType = $this->_getListBonusType();
        $bonusTypeKey = array_rand($listBonusType);
        return $listBonusType[$bonusTypeKey];
    }


    private function _getListBonusType(): array {
        $list[] = BonusInterface::TYPE_BONUS_POINTS;
        $this->_checkLimitBonus($this->money_bonus, BonusInterface::TYPE_BONUS_MONEY) ?: $list[] = BonusInterface::TYPE_BONUS_MONEY;
        $this->_checkLimitBonus($this->object_bonus, BonusInterface::TYPE_BONUS_OBJECT) ?: $list[] = BonusInterface::TYPE_BONUS_OBJECT;
        return $list;
    }

    private function _checkLimitBonus(LimitedBonusInterface $bonus, $type){
        return $bonus->checkOverLimit($this->repository->getCountByType($type));
    }

    private function _getSettingsMoneyBonus(): BonusSettings{
        return (new BonusSettings())->setInterval(10, 150)->setLimit(3);
    }

    private function _getSettingsPointsBonus(): BonusSettings{
        return (new BonusSettings())->setInterval(50, 300);
    }

    private function _getSettingsObjectBonus(): BonusSettings{
        return (new BonusSettings())->setList(['Носки', 'Новые носки', 'Чистые новые носки'])->setLimit(10);
    }


}