<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use App\Application\Middleware\ContentNegotiation\ContentTypeMiddleware;
use Slim\App;

return function (App $app) {
    // Add Routing Middleware
    $app->addRoutingMiddleware();

     // Add Content Negotiation Middleware
    $app->add(ContentTypeMiddleware::class);

    // Add Body Parsing Middleware
    $app->addBodyParsingMiddleware();

   
    // Add Session Middleware
    $app->add(SessionMiddleware::class);
};
