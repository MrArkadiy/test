<?php

namespace frontend\config\container;


use project\account\AccountServices;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Container implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(AccountServices::class, function (){
            return new AccountServices(Yii::$app->user->id);
        });
    }
}