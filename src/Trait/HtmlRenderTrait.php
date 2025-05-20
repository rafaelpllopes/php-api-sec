<?php

namespace Alura\Mvc\Trait;

trait HtmlRenderTrait
{  
    private function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);

        $templatePath = __DIR__ . '/../../views/';
        ob_start(); //Buffer de saida
        require_once  $templatePath . $templateName . '.php';
        
        return ob_get_clean(); //Retorna o conteudo e limpa o buffer
    }
}