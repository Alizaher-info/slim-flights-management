<?php

declare(strict_types=1);

namespace App\Application\Actions\Database;

use App\Application\Actions\Action;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class TestConnectionAction extends Action
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($logger);
        $this->entityManager = $entityManager;
    }

    protected function action(): Response
    {
        try {
            // Test the connection
            $connection = $this->entityManager->getConnection();
            
            // Execute a simple query to test the connection
            $result = $connection->executeQuery('SELECT 1');
            
            $databasePlatform = $connection->getDatabasePlatform();
            return $this->respondWithData([
                'status' => 'Connected',
                'database_platform' => get_class($databasePlatform),
                'database_name' => $connection->getDatabase(),
                'test_query' => $result->fetchOne()
            ]);
        } catch (\Exception $e) {
            return $this->respondWithData([
                'status' => 'Connection failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
