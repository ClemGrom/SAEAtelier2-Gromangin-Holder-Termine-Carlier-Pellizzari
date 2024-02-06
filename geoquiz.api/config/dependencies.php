<?php


use geoquiz\api\domain\middlewares\BeforeCheckJWT;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
//use geoquiz\api\domain\service\catalogue\CatalogueService;
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

//    'catalogue.service' => function(ContainerInterface $container) {
//        return new CatalogueService();
//    },


];