<?php

namespace project\bonus\interfaces;


use project\bonus\entities\ResultBonusEntity;

interface BonusInterface
{

    const TYPE_BONUS_MONEY = 'MONEY_BONUS';
    const TYPE_BONUS_OBJECT = 'OBJECT_BONUS';
    const TYPE_BONUS_POINTS = 'POINTS_BONUS';

    const STATUS_BONUS_CANCELLED = 'CANCELLED';
    const STATUS_BONUS_RECEIVED = 'RECEIVED';
    const STATUS_BONUS_NEW = 'NEW';



    public function getBonus(): ResultBonusEntity;

    public function getType();

}