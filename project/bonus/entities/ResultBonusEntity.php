<?php

namespace project\bonus\entities;


class ResultBonusEntity
{
    public $value;
    public $type;

    public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

}