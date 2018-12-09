<?php

namespace project\account\interfaces;


interface AccountInterface
{


    /**
     * @param int $amount
     * @return mixed
     */
    public function upBalance(int $amount);

    /**
     * @param int $amount
     * @return mixed
     */
    public function downBalance(int $amount);

    /**
     * @return int
     */
    public function getBalance(): int;


}