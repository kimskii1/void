<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Index(fields: ['login'], name: 'i_user_login')]
#[ORM\HasLifecycleCallbacks]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use EntityIdIdentityTrait, EntityTimestampableTrait;

    #[ORM\Column(length: 128, options: [
        'comment' => 'User login',
    ])]
    private string $login;

    #[ORM\Column(length: 128, options: [
        'comment' => 'User password hash',
    ])]
    private string $password;

    #[ORM\Column(length: 64, options: [
        'comment' => 'User name',
    ])]
    private string $name;

    #[ORM\Column(length: 128, options: [
        'comment' => 'User surname',
    ])]
    private string $surname;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER'
        ];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }
}
