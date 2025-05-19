<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;

class LogoutController implements Controller
{
    #[\Override]
    public function processaRequisicao(): void
    {        
        session_destroy();
        header('Location: /login');
    }
}