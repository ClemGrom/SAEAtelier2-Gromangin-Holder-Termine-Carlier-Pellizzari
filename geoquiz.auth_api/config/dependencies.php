<?php

use geoquiz\auth\api\domain\provider\AuthProvider;
use geoquiz\auth\api\domain\service\auth\AuthService;
use geoquiz\auth\api\domain\provider\JwtManager;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    JwtManager::class => function(ContainerInterface $c) {
        $settings = $c->get('settings')['jwt'];
        return new JwtManager($settings['secret'], $settings['expires'], $settings['issuer']);
    },
    AuthService::class => function(ContainerInterface $c) {
        return new AuthService(
            $c->get(AuthProvider::class),
            $c->get(JwtManager::class),
            $c->get(Logger::class)
        );
    },
    Logger::class => function(ContainerInterface $c) {
        $logger = new Logger('auth');
        $logger->pushHandler(new StreamHandler('../logs/errors.log', Logger::DEBUG));
        return $logger;
    },

];