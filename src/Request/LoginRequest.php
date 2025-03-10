<?php

namespace Request;

class LoginRequest
{
    public function __construct(private array $data)
    {
    }
    public function getName() : string
    {
        return $this->data['username'];
    }
    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function validateLogin(): array
    {
        $errors = [];
        if (!(isset($this->data['username']))) {
            $errors = "username incorrect";
        }
        if (!(isset($this->data['password']))) {
            $errors = "password incorrect";
        }

        return $errors;
    }
}