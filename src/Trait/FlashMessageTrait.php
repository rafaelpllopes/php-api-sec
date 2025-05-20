<?php

namespace Alura\Mvc\Trait;

trait FlashMessageTrait
{
    private function sendError(string $message) : void {
        $_SESSION["error_message"]  = $message;
    }
}