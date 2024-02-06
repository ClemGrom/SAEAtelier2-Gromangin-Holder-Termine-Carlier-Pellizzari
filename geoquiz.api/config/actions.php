<?php

use geoquiz\api\app\action\DifficultiesListAction;
use geoquiz\api\app\action\GameCreateAction;
use geoquiz\api\app\action\GameDetailsAction;
use geoquiz\api\app\action\GameSubmitAction;
use geoquiz\api\app\action\UserGamesListAction;
use Psr\Container\ContainerInterface;

return [

    DifficultiesListAction::class => function (ContainerInterface $container) {
        return new DifficultiesListAction($container->get('game.service'));
    },

    GameCreateAction::class => function (ContainerInterface $container) {
        return new GameCreateAction($container->get('game.service'));
    },

    GameDetailsAction::class => function (ContainerInterface $container) {
        return new GameDetailsAction($container->get('game.service'));
    },

    GameSubmitAction::class => function (ContainerInterface $container) {
        return new GameSubmitAction($container->get('game.service'));
    },

    UserGamesListAction::class => function (ContainerInterface $container) {
        return new UserGamesListAction($container->get('game.service'));
    },

];