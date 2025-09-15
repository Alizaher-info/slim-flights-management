<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

require_once __DIR__ . '/vendor/autoload.php';

// Doctrine Konfiguration
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Entity'],
    isDevMode: true,
);

// Datenbank Parameter
$connectionParams = [
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => 3307,
    'dbname'   => 'flights',
    'user'     => 'slim',
    'password' => 'slim',
    'charset'  => 'utf8mb4'
];

// EntityManager erstellen
$connection = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($connection, $config);

// Migrations Konfiguration
$configurationArray = [
    'table_storage' => [
        'table_name' => 'migrations',
    ],
    'migrations_paths' => [
        'App\\Migrations' => __DIR__ . '/migrations'
    ],
];

file_put_contents(
    __DIR__ . '/migrations.php',
    '<?php return ' . var_export($configurationArray, true) . ';'
);

// DependencyFactory erstellen und zurückgeben
return DependencyFactory::fromEntityManager(
    new PhpFile(__DIR__ . '/migrations.php'),
    new ExistingEntityManager($entityManager)
);
