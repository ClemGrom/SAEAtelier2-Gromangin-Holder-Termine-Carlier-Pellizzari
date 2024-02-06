<?php

use geoquiz\api\app\action\DifficultiesListAction;
use Psr\Container\ContainerInterface;

return [

    DifficultiesListAction::class => function (ContainerInterface $container) {
        return new DifficultiesListAction($container->get('game.service'));
    },

];