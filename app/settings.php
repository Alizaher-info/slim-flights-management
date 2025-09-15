<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    'driver'   => 'pdo_mysql',
                    'host'     => '127.0.0.1',    // Use IP instead of localhost
                    'port'     => 3307,           // Mapped Docker port
                    'database' => 'flights',       // From MYSQL_DATABASE
                    'user'     => 'slim',          // From MYSQL_USER
                    'password' => 'slim',          // From MYSQL_PASSWORD
                    'charset'  => 'utf8mb4',
                    'serverVersion' => '8.0'       // MySQL version
                ],
            ]);
        }
    ]);
};
