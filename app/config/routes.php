<?php

declare(strict_types=1);

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use Scratch\Handler\HomeHandler;

return function (ContainerInterface $c) : Dispatcher {
    return FastRoute\simpleDispatcher(function (RouteCollector $r) use ($c) {
        $r->get( '/', $c->get(HomeHandler::class));
    });
};
