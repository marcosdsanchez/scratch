<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require 'app/config/container.php')();
    $fastRouteDispatcher = (require 'app/config/routes.php')($container);
    $queue = (require 'app/config/pipeline.php')($container, $fastRouteDispatcher);
    $response = (new Relay\Relay($queue))->handle(\Zend\Diactoros\ServerRequestFactory::fromGlobals());

    $container->get(\Zend\HttpHandlerRunner\Emitter\EmitterInterface::class)->emit($response);
})();
