<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList();
        $router->addRoute('list', 'Homepage:list');
        $router->addRoute('post/<id \d+>/<slug [a-zA-Z0-9\\-\\.]+>.html', 'Post:show');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

        return $router;
    }
}
