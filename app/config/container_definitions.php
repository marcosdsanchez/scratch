<?php

declare(strict_types=1);

use Middlewares\RequestHandler;
use MustacheTemplatingEngine\MustacheEngine;
use Psr\Container\ContainerInterface;
use Scratch\Handler\HomeHandler;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\TemplateNameParserInterface;
use function DI\create;
use function DI\get;

return function () : array {
    return [
        TemplateNameParserInterface::class => TemplateNameParser::class,
        Mustache_Loader_FilesystemLoader::class => create()
            ->constructor(__DIR__ . '/../../src/Scratch/Resources/views'),
        Mustache_Engine::class => function (ContainerInterface $c) {
            return new Mustache_Engine(['loader' => $c->get(Mustache_Loader_FilesystemLoader::class)]);
        },
        EngineInterface::class => function (ContainerInterface $c) {
            return new MustacheEngine($c->get(Mustache_Engine::class), new TemplateNameParser());
        },
        HomeHandler::class => create()->constructor(get(EngineInterface::class)),
        RequestHandler::class => function (ContainerInterface $c) {
            return new RequestHandler($c);
        },
        \Zend\HttpHandlerRunner\Emitter\EmitterInterface::class => function () {
            $emitter = new \Zend\HttpHandlerRunner\Emitter\EmitterStack();
            $emitter->push(new \Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter());
            $emitter->push(new \Zend\HttpHandlerRunner\Emitter\SapiEmitter());

            return $emitter;
        }
    ];
};
