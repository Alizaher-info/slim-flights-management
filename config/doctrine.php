<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

return function (array $settings): EntityManagerInterface {
    // Create a simple "default" Doctrine ORM configuration for Attributes
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: array(__DIR__ . "/../src/Entity"),
        isDevMode: true,
    );

    // configuring the database connection
    $connection = DriverManager::getConnection([
        'driver'   => $settings['doctrine']['driver'],
        'host'     => $settings['doctrine']['host'],
        'port'     => $settings['doctrine']['port'],
        'dbname'   => $settings['doctrine']['database'],
        'user'     => $settings['doctrine']['user'],
        'password' => $settings['doctrine']['password'],
        'charset'  => $settings['doctrine']['charset']
    ], $config);

    // obtaining the entity manager
    return new EntityManager($connection, $config);
};
