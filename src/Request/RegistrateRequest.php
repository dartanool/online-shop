<?php

namespace Request;

use Model\User;

class RegistrateRequest
{
    public function __construct(private array $data)
    {
    }
    public function getName() : string
    {
        return $this->data['name'];
    }

    public function getEmail() : string
    {
        return $this->data['email'];
    }

    public function getPassword() : string
    {
        return $this->data['password'];
    }

    public function getCheckPassword() : string
    {
        return $this->data['check_password'];
    }

    public function validateRegistration(): array
    {
        $errors = [];

        if (empty($this->data['name'])) {
            $errors['name'] = "Name is not filled";
        } elseif (strlen($this->data['name']) < 3) {
            $errors['name'] = "Name {$this->data['name']} too short";
        }

        if (empty($this->data['password'])) {
            $errors['password'] = "Password is not filled";
        } elseif (empty($this->data['check_password'])) {

            $errors['password'] = "Check_password is not filled";

        } elseif (!((strlen($this->data['password']) > 4 && strlen($this->data['password']) < 72) &&
            preg_match('/[A-Z]/', $this->data['password']) &&
            preg_match('/[a-z]/', $this->data['password']) &&
            preg_match('/[0-9]/', $this->data['password']))) {
            $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
        } elseif ($this->data['check_password'] !== $this->data['password']) {
            $errors['password'] = "Пароли не совпадают";
        }

        if (empty($this->data['email'])) {
            $errors['email'] = "Email is not filled";
        } elseif (!(filter_var($this->data['email'], FILTER_VALIDATE_EMAIL))) {
            $errors['email'] = "Email {$this->data['email']} не валиден.";
        } else {

            $statement = User::getByEmail($this->data['email']);

            if (!(empty($statement))) {
                $errors['email'] = "Email {$this->data['email']} already exists";
            }
        }
        return $errors;
    }

}