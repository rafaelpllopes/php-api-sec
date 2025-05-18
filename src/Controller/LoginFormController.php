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
        require_once __DIR__ . '/../../views/login-form.php';
    }
}