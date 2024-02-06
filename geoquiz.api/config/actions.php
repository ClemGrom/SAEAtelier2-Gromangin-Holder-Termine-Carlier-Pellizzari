<?php

use geoquiz\api\app\action\DifficultiesListAction;
use geoquiz\api\app\action\GameCreateAction;
use Psr\Container\ContainerInterface;

return [

    DifficultiesListAction::class => function (ContainerInterface $container) {
        return new DifficultiesListAction($container->get('game.service'));
    },

    GameCreateAction::class => function (ContainerInterface $container) {
        return new GameCreateAction($container->get('game.service'));
    },

];