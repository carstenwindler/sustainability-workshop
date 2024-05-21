<?php

declare(strict_types=1);

use GreenElephpant\CarbonAware\DataProvider\EnergyCharts\EnergyCharts;
use GreenElephpant\CarbonAware\Service\CarbonAwareService;
use Laminas\Diactoros\ResponseFactory;
use SustainabilityWorkshop\CarbonAwareFactory;
use SustainabilityWorkshop\Controller\CarbonIntensityController;

require_once '../vendor/autoload.php';

//
// create request instance
//
$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);


//
// Setup container
//
$container = new League\Container\Container();
$container
    ->add(CarbonIntensityController::class)
    ->addArgument(CarbonAwareService::class);

$container
    ->add(
        CarbonAwareService::class,
        CarbonAwareFactory::create(
            EnergyCharts::class,
            'DE'
        )
    );


//
// Initialise router
//
$responseFactory = new ResponseFactory();
$strategy = new League\Route\Strategy\JsonStrategy($responseFactory);
$strategy->setContainer($container);
$router = new League\Route\Router();
$router->setStrategy($strategy);

//
// Configure routes
//
$router->map(
    'GET',
    '/carbon-intensity/current',
    [CarbonIntensityController::class, 'current']
);

//
// Dispatch the request to receive a response object
//
$response = $router->dispatch($request);

//
// Finally send the response
//
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
