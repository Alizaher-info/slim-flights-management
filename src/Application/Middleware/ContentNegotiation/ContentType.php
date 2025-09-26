<?php

declare(strict_types=1);

namespace App\Application\Middleware\ContentNegotiation;

enum ContentType: string
{
    case JSON = 'application/json';
    case HTML = 'text/html';
    case XML = 'application/atom+xml';
}
