<?php

namespace Alura\Mvc\Controller;

abstract class ControleWithHtml
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    
    protected function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);

        ob_start(); //Buffer de saida
        require_once  self::TEMPLATE_PATH . $templateName . '.php';
        
        return ob_get_clean(); //Retorna o conteudo e limpa o buffer
    }
}