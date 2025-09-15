<?php

return [
    'dbname' => 'flights',
    'user' => 'slim',
    'password' => 'slim',
    'host' => '127.0.0.1',
    'driver' => 'pdo_mysql',
    'port' => 3307,
    'charset' => 'utf8mb4',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
    ]
];
