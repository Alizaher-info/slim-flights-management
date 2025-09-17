<?php

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use App\Application\Middleware\SessionMiddleware;
use App\Application\Middleware\ContentNegotiation\ContentTypeMiddleware;

return function (App $app) {

    $app->add(ContentTypeMiddleware::class);
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(
        true,  // displayErrorDetails
        true,  // logErrors
        true   // logErrorDetails
    );

    // Add Session Middleware
    $app->add(SessionMiddleware::class);

    return $app;
};
