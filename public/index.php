<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Snipcode\Booting::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();
