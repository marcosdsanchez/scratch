<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

return function () : ContainerInterface {
    $containerBuilder = new ContainerBuilder;
    $definitions = (require __DIR__ . '/container_definitions.php')();
    $containerBuilder->addDefinitions($definitions);

    return $containerBuilder->build();
};
