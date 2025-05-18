<?php

namespace Alura\Mvc\Entity;

class User
{
    public readonly int $id;
    public readonly string $email;

    public function __construct(
        string $email,
        public readonly string $password,
    ) {
        $this->setUrl($email);
    }

    private function setUrl(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException();
        }

        $this->email = $email;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
