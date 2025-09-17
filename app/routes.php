<?php

declare(strict_types=1);

use Slim\App;
use App\Entity\Flight;
use App\Controller\FlightController;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\ListUsersAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });


    $app->get('/flights', [FlightController::class, 'getAllFlights']);
    $app->get('/flights/{id}', [FlightController::class, 'getFlightById']);
    $app->get('/test-db', \App\Application\Actions\Database\TestConnectionAction::class);

  
};
