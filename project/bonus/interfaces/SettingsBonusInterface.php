<?php

namespace project\bonus\interfaces;


interface SettingsBonusInterface
{

    public function setInterval(int $min, int $max);
    public function setList(array $list);
    public function setLimit(int $limit);

    public function getIntervalMin();
    public function getIntervalMax();
    public function getList();
    public function getLimit();

}