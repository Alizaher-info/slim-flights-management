<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Flight;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlightController extends ApiController
{
    public function getAllFlights(Request $request, Response $response): Response
    {
        $flights = $this->entityManager->getRepository(Flight::class)->findAll();
        $data = $this->serializer->serialize(['flights' => $flights], 'json');
        $response->getBody()->write($data);
        return $response;
    }

    public function getFlightById(Request $request, Response $response, array $args): Response
    {
        $flightId = (int) $args['id'];
        $flight = $this->entityManager->getRepository(Flight::class)->find($flightId);

        if (!$flight) {
            $error = $this->serializer->serialize(['error' => 'Flight not found'], 'json');
            $response->getBody()->write($error);
            return $response->withStatus(404);
        }

        $data = $this->serializer->serialize(['flight' => $flight], 'json');
        $response->getBody()->write($data);
        return $response;
    }
}
