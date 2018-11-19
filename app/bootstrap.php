<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode('92.245.5.107');
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/Config/config.neon');

$container = $configurator->createContainer();

try {
    \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
    \Doctrine\DBAL\Types\Type::addType('uuid_binary', 'Ramsey\Uuid\Doctrine\UuidBinaryType');
} catch (\Doctrine\DBAL\DBALException $e) {
}

return $container;
