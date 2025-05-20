<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Trait\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{
    use HtmlRenderTrait;

    public function __construct(private UserRepository $userRepository)
    {
    }

    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
        if(($_SESSION['logado'] ?? false) == true) {
            return new Response(400, [
                'Location' => '/login'
            ]);
        }

        return new Response(200, body: $this->renderTemplate('login-form'));
    }
}