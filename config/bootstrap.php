<?php

namespace app\config;

use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\di\Instance;
use shop\dispatchers\EventDispatcher;
use shop\dispatchers\DeferredEventDispatcher;
use shop\dispatchers\AsyncEventDispatcher;
use yii\queue\Queue;
use yii\rbac\ManagerInterface;
use yii\mail\MailerInterface;
use shop\cart\Cart;
use shop\cart\cost\calculator\DynamicCost;
use shop\cart\cost\calculator\SimpleCost;
use shop\cart\storage\HybridStorage;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
	{
        $container = \Yii::$container;
        
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(Queue::class, function () use ($app) {
            return $app->get('queue');
        });

        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new AsyncEventDispatcher($container->get(Queue::class)));
        });

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });
        
        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new DynamicCost(new SimpleCost())
            );
        });
	}
}