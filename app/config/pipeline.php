<?php

declare(strict_types=1);

use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Whoops;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container, \FastRoute\Dispatcher $dispatcher) : array {
    return [
            $container->get(Whoops::class),
            new FastRoute($dispatcher),
            $container->get(RequestHandler::class),
        ];
};
