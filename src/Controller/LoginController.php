<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Trait\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(
        private UserRepository $userRepository
    )
    {  
    }

    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if ($email === false || $email === null) {
            $this->sendError("Usuário ou senha inválidos");
            return new Response(400, [
                'Location' => '/login'
            ]);
        }
        
        if ($password === false || $password === null) {
            $this->sendError("Usuário ou senha inválidos");
            return new Response(400, [
                'Location' => '/login'
            ]);
        }
        
        $login = $this->userRepository->login($email);

        if ($login === null) {
            $this->sendError("Usuário ou senha inválidos");
            return new Response(400, [
                'Location' => '/login'
            ]);
        }

        $correctPassword = password_verify($password, $login->password ?? '');
        
        if (!$correctPassword) {
            $this->sendError("Usuário ou senha inválidos");
            return new Response(400, [
                'Location' => '/login'
            ]);
        }
        
        if (password_needs_rehash($login->password, PASSWORD_ARGON2ID)) {
            $this->userRepository->updatePassword($password, $login->id);
        }
        
        $_SESSION['logado'] = true;
        return new Response(302, [
            'Location' => '/'
        ]);
    }
}