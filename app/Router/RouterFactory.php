<?php

declare(strict_types=1);

namespace Snipcode\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\UI\Presenter;

final class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList();

        $router->addRoute('/', [Presenter::PRESENTER_KEY => 'Homepage:default']);
        $router->addRoute('/<slug>', [Presenter::PRESENTER_KEY => 'Snippet:default']);
        $router->addRoute('/raw/<slug>', [Presenter::PRESENTER_KEY => 'Snippet:raw']);
		$router->addRoute('/fork/<forkId>', [Presenter::PRESENTER_KEY => 'Homepage:default']);

		return $router;
	}
}
