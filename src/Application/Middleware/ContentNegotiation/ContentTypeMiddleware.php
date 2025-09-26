<?php

declare(strict_types=1);

namespace App\Application\Middleware\ContentNegotiation;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request ;
use App\Application\Middleware\ContentNegotiation\ContentType;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class ContentTypeMiddleware implements MiddlewareInterface
{
    // Middleware implementation goes here
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Get the Accept header from the request
        $acceptHeader = $request->getHeaderLine('Accept');
      
       $requestFormats = explode(',',$acceptHeader);
        foreach($requestFormats as $requestFormat)
        {
            $format = ContentType::tryFrom(trim($requestFormat));
            if ($format !== null) {
                $request = $request->withAttribute('Content-Type', $format);
                break;
            }
            $request = $request->withAttribute('Content-Type', ContentType::JSON);

        }
        {
         
        }
        // Call the next middleware or request handler
        return $handler->handle($request);
    }
}