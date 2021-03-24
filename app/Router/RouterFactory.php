<?php

declare(strict_types=1);

namespace App\Router;

use Nette\Application\Routers\RouteList;
use Nette\Application\UI\Presenter;

final class RouterFactory
{
    public function create(): RouteList
    {
        $router = new RouteList();

        if (!$this->isMigrating()) {
            $router->add($this->createFrontRouter());
        }

        return $router;
    }

    private function createFrontRouter(): RouteList
    {
        $frontRouter = new RouteList('Front');

        $frontRouter->addRoute('/', [
            Presenter::PRESENTER_KEY => 'Homepage', 
            Presenter::ACTION_KEY => 'default'
        ]);
        
        $frontRouter->addRoute('/<slug>', [
            Presenter::PRESENTER_KEY => 'Snippet', 
            Presenter::ACTION_KEY => 'default'
        ]);
        
        $frontRouter->addRoute('/raw/<slug>', [
            Presenter::PRESENTER_KEY => 'RawSnippet', 
            Presenter::ACTION_KEY => 'default'
        ]);
        
        $frontRouter->addRoute('/fork/<forkId>', [
            Presenter::PRESENTER_KEY => 'Homepage', 
            Presenter::ACTION_KEY => 'default'
        ]);
        
        return $frontRouter;
    }

    private function isMigrating(): bool
    {
        if (isset($_SERVER['argv']) && count($_SERVER['argv']) > 1) {
            return str_contains($_SERVER['argv'][1], 'migration');
        }

        return false;
    }
}
