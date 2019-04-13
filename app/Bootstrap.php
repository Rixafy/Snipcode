<?php

declare(strict_types=1);

namespace Snipcode;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Nette\Configurator;

class Bootstrap
{
	/**
	 * @throws DBALException
	 */
	public static function boot(): Configurator
	{
		self::additionalSetup();

		$configurator = new Configurator;

		$configurator->setDebugMode(isset($_SERVER['DEBUG']) && $_SERVER['DEBUG'] === 'true');
		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig(__DIR__ . '/Config/common.neon');

		return $configurator;
	}

	/**
	 * @throws DBALException
	 */
	private static function additionalSetup(): void
	{
		Type::addType('uuid_binary', 'Ramsey\Uuid\Doctrine\UuidBinaryType');
	}
}
