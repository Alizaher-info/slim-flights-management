# Integration von Doctrine 3.5.2 mit Slim 4 Framework

## 1. Installation der benötigten Pakete

```bash
composer require doctrine/orm:^3
composer require doctrine/dbal:^4
composer require doctrine/migrations:^3.9
composer require symfony/cache:^7
```

## 2. Konfigurationsdateien erstellen

### 2.1 Doctrine Migrations Konfiguration (migrations.php)
```php
<?php
return [
    'table_storage' => [
        'table_name' => 'migrations',
    ],
    'migrations_paths' => [
        'App\\Migrations' => __DIR__ . '/migrations',
    ],
];
```

### 2.2 Migrations Datenbank-Konfiguration (migrations-db.php)
```php
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
```

## 3. Doctrine in Slim DI Container einrichten (app/dependencies.php)

```php
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

// In der dependencies.php:
$containerBuilder->addDefinitions([
    \Doctrine\ORM\EntityManagerInterface::class => function (ContainerInterface $c) {
        $settings = $c->get(SettingsInterface::class);
        $doctrineSettings = $settings->get('doctrine');
        
        $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../src/Entity'],
            true
        );
        
        return new \Doctrine\ORM\EntityManager(
            \Doctrine\DBAL\DriverManager::getConnection([
                'driver' => $doctrineSettings['driver'],
                'host' => $doctrineSettings['host'],
                'port' => $doctrineSettings['port'],
                'dbname' => $doctrineSettings['database'],
                'user' => $doctrineSettings['user'],
                'password' => $doctrineSettings['password'],
                'charset' => $doctrineSettings['charset'],
            ]),
            $config
        );
    },
]);
```

## 4. Doctrine Einstellungen (app/settings.php)

```php
// In der settings.php:
'doctrine' => [
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => 3307,
    'database' => 'flights',
    'user'     => 'slim',
    'password' => 'slim',
    'charset'  => 'utf8mb4',
    'serverVersion' => '8.0'
],
```

## 5. Composer Scripts für Doctrine Commands

```json
{
    "scripts": {
         "migrations": "./vendor/bin/doctrine-migrations",
        "migrations:diff": "vendor/bin/doctrine-migrations migrations:diff",
        "migrations:generate": "vendor/bin/doctrine-migrations migrations:generate",
        "migrations:migrate": "vendor/bin/doctrine-migrations migrations:migrate"
    }
}
```

## 6. Migrations Befehle

### Neue Migration erstellen:
```bash
composer migrations:generate
```

### Migration aus Entity-Änderungen erstellen:
```bash
composer migrations:diff
```

### Migrationen ausführen:
```bash
composer migrations:migrate
```

### Status der Migrationen prüfen:
```bash
composer migrations:status
```

## 7. Wichtige Hinweise

1. Stellen Sie sicher, dass der Entity-Ordner existiert: `src/Entity`
2. Aktivieren Sie die Doctrine Attribute in PHP 8+
3. Migrations-Ordner muss schreibbar sein
4. Datenbank muss existieren und erreichbar sein
5. Korrekte Berechtigungen für den Datenbankbenutzer

