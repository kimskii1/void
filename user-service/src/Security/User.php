<?php

declare(strict_types=1);

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Uid\Uuid;

final class User implements JWTUserInterface
{
    public function __construct(
        private readonly string $login,
        private readonly Uuid   $id,
        private readonly string $name,
        private readonly string $surname,
        private readonly array $roles
    ) {
    }

    public static function createFromPayload($username, array $payload): self
    {
        return new self(
            $username,
            Uuid::fromString($payload['id']),
            $payload['name'],
            $payload['surname'],
            $payload['roles']
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }
}
