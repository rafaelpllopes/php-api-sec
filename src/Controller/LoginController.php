<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;

class LoginController implements Controller
{
    public function __construct(
        private UserRepository $userRepository
    )
    {  
    }

    #[\Override]
    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if ($email === false || $email === null) {
            header('Location: /login?sucesso=0');
            return;
        }
        
        if ($password === false || $password === null) {
            header('Location: /login?sucesso=0');
            return;
        }
        
        $login = $this->userRepository->login($email);

        if ($login === null) {
            header('Location: /login?sucesso=0');
            return;
        }


        $correctPassword = password_verify($password, $login->password ?? '');

        if (!$correctPassword) {
            header('Location: /login?sucesso=0');
            return;
        }
        
        $_SESSION['logado'] = true;
        header('Location: /');
    }
}