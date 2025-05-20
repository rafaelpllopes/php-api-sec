<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Trait\HtmlRenderTrait;

class LoginFormController implements Controller
{
    use HtmlRenderTrait;

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

        echo $this->renderTemplate('login-form');
    }
}