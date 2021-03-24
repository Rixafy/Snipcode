<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;

class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator();

        $debugMode = substr(dirname(__FILE__), -7) !== 'www/app';

        $configurator->setDebugMode($debugMode);
        $configurator->enableTracy(__DIR__ . '/../log');

        $configurator->setTimeZone('Europe/Prague');
        $configurator->setTempDirectory(__DIR__ . '/../temp');

        $configurator->addConfig(__DIR__ . '/../config/main.neon');

        $configurator->addConfig(__DIR__ . '/../config/parameters_dev.neon');
        if (!$debugMode) {
            $configurator->addConfig(__DIR__ . '/../config/parameters_prod.neon');
        }
        
        return $configurator;
    }
}
