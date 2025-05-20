<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutController implements RequestHandlerInterface
{
    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {        
        session_destroy();
        return new Response(200, [
            'Location' => '/login'
        ]);
    }
}