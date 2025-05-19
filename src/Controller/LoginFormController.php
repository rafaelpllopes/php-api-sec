<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;

class LoginFormController implements Controller
{
    public function __construct(private UserRepository $userRepository)
    {  
    }

    #[\Override]
    public function processaRequisicao(): void
    {
        // if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
        if(($_SESSION['logado'] ?? false) == true) {
            header('Location: /');
            return;
        }

        require_once __DIR__ . '/../../views/login-form.php';
    }
}