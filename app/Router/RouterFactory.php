<?php declare(strict_types=1);

namespace App;

use Nette;
use Nette\Application\Routers\Route;
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
		$router[] = new Route('<slug>', 'Snippet:default');
		$router[] = new Route('raw/<slug>', 'Snippet:raw');
		$router[] = new Route('fork/<forkId>', 'Homepage:default');
		$router[] = new Route('', 'Homepage:default');
		return $router;
	}
}
