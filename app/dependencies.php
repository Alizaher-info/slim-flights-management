<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

return function (ContainerBuilder $containerBuilder) {
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
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        SerializerInterface::class => function (ContainerInterface $c) {
            $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                return $innerObject instanceof \DateTime ? $innerObject->format('Y-m-d H:i:s') : '';
            };

            $defaultContext = [
                ObjectNormalizer::CALLBACKS => [
                    'departureTime' => $dateCallback,
                    'arrivalTime' => $dateCallback
                ],
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                },
                ObjectNormalizer::CIRCULAR_REFERENCE_LIMIT => 1
            ];

            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
            return new Serializer($normalizers, $encoders);
        },
    ]);
};
