<?php

/* @var $this yii\web\View */
/* @var $account \project\account\AccountServices*/

$this->title = 'Тестовое задание';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Привет <?=$account->getUserName()?></h1>
        <h2>Твой балланс: <?=$account->getBalance()?></h2>
        <p class="lead">Ты можешь получить один из трех возможных призов</p>
        <p><a class="btn btn-lg btn-success" href="/site/get-bonus">Получить приз</a></p>
    </div>

</div>
