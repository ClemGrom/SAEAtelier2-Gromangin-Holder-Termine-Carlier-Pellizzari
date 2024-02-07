<?php


use geoquiz\api\domain\middlewares\BeforeCheckJWT;
use geoquiz\api\domain\middlewares\BeforeCheckOwnership;
use geoquiz\api\domain\service\GameService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

return [

    'logger' => function(ContainerInterface $container) {
        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler($container->get('logger.file'), $container->get('logger.level')));
        return $logger;
    },

    'checkJwt' => function(ContainerInterface $container) {
        return new BeforeCheckJWT($container->get('uri.auth'));
    },

    'game.service' => function(ContainerInterface $container) {
        return new GameService($container->get('logger'));
    },

    'checkOwnership' => function(ContainerInterface $container) {
        return new BeforeCheckOwnership($container->get('game.service'));
    },

];