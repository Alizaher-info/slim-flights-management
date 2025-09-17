<?php

declare(strict_types=1);

namespace App\Application\Middleware\ContentNegotiation;

use App\Application\Middleware\ContentNegotiation\ContentNegotiatorInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContentNegotiator implements ContentNegotiatorInterface
{
    public function negotiate(ServerRequestInterface $request): ServerRequestInterface
    {
        $acceptHeader = $request->getHeaderLine('Accept');

        // Default to JSON if no Accept header is present
        if (empty($acceptHeader)) {
            return $request->withAttribute('content-type', ContentType::JSON->value);
        }

        // Parse Accept header and get the best matching format
        $requestFormats = array_map('trim', explode(',', $acceptHeader));

        foreach ($requestFormats as $requestFormat) {
            // Remove quality value if present (e.g., "application/json;q=0.8" -> "application/json")
            $format = explode(';', $requestFormat)[0];
            $contentType = ContentType::tryFrom($format);
            if ($contentType !== null) {
                return $request->withAttribute('content-type', $contentType->value);
            }
        }

        // If no supported format is found, default to JSON
        return $request->withAttribute('content-type', ContentType::JSON->value);
    }
}
