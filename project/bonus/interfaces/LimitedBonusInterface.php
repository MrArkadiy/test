<?php


namespace project\bonus\interfaces;


interface LimitedBonusInterface
{

    function checkOverLimit($current_count);

}