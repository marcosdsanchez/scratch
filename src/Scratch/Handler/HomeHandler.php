<?php

declare(strict_types=1);

namespace Scratch\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Templating\EngineInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HomeHandler implements RequestHandlerInterface
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->templating->render('home', ['planet' => 'World!']));
    }
}
