<?php

declare(strict_types=1);

namespace Snipcode\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$router->addRoute('<slug>', 'Snippet:default');
		$router->addRoute('raw/<slug>', 'Snippet:raw');
		$router->addRoute('fork/<forkId>', 'Homepage:default');
		$router->addRoute('', 'Homepage:default');

		return $router;
	}
}
