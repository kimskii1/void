<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'ERR_EMPTY_LOGIN')]
        public ?string $login,
        #[Assert\NotBlank(message: 'ERR_EMPTY_PASSWORD')]
        public ?string $password,
        #[Assert\NotBlank(message: 'ERR_EMPTY_NAME')]
        public ?string $name,
        #[Assert\NotBlank(message: 'ERR_EMPTY_SURNAME')]
        public ?string $surname
    ) {
    }
}
