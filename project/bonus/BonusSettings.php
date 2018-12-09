<?php

namespace project\bonus;


use project\bonus\interfaces\SettingsBonusInterface;

class BonusSettings implements SettingsBonusInterface
{
    private $min;
    private $max;
    private $list;
    private $limit;

    public function setInterval(int $min, int $max): BonusSettings
    {
        $this->min = $min;
        $this->max = $max;
        return $this;
    }

    public function setList(array $list): BonusSettings {
        $this->list = $list;
        return $this;
    }

    public function setLimit(int $limit): BonusSettings{
        $this->limit = $limit;
        return $this;
    }

    public function getIntervalMin(){
        return $this->min;
    }

    public function getIntervalMax(){
        return $this->max;
    }

    public function getList(){
        return $this->list;
    }

    public function getLimit(){
        return $this->limit;
    }

}