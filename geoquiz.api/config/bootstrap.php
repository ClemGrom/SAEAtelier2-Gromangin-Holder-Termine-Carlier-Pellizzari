<?php

use geoquiz\api\domain\middlewares\Cors;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;

// ajout du coneteneur de dépendances
$settings = require_once __DIR__ . DIRECTORY_SEPARATOR . 'settings.php';
$depedencies = require_once __DIR__ . DIRECTORY_SEPARATOR . 'dependencies.php';
$actions = require_once __DIR__ . DIRECTORY_SEPARATOR . 'actions.php';

$builder = new \DI\ContainerBuilder();
    $builder->addDefinitions($settings);
    $builder->addDefinitions($depedencies);
    $builder->addDefinitions($actions);

$container = $builder->build();
    $app = AppFactory::createFromContainer($container);
        $app->add(new Cors());
        $app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

//gestionnaire d'erreur
$errorMiddleware = $app->addErrorMiddleware(true, false, false);
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->forceContentType('application/json');

// Boot Eloquent
$capsule = new Capsule;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Retourner l'application configurée
return $app;