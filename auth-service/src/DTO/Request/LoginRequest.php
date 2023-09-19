<?php

namespace App\DTO\Request;

class LoginRequest
{
    public function __construct(
        public ?string $login,
        public ?string $password
    ) {
    }
}