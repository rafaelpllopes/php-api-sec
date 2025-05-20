<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Trait\FlashMessageTrait;

class LoginController implements Controller
{
    use FlashMessageTrait;

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
            $this->sendError("Usuário ou senha inválidos");
            header('Location: /login');
            return;
        }
        
        if ($password === false || $password === null) {
            $this->sendError("Usuário ou senha inválidos");
            header('Location: /login');
            return;
        }
        
        $login = $this->userRepository->login($email);

        if ($login === null) {
            $this->sendError("Usuário ou senha inválidos");
            header('Location: /login');
            return;
        }

        $correctPassword = password_verify($password, $login->password ?? '');
        
        if (!$correctPassword) {
            $this->sendError("Usuário ou senha inválidos");
            header('Location: /login');
            return;
        }
        
        if (password_needs_rehash($login->password, PASSWORD_ARGON2ID)) {
            $this->userRepository->updatePassword($password, $login->id);
        }
        
        $_SESSION['logado'] = true;
        header('Location: /');
    }
}