<?php

namespace App\Service;

use App\DTO\Request\RegisterRequest;
use App\Entity\User;
use App\Exception\ServiceException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $passwordHasher,
        protected JWTTokenManagerInterface $jwtManager
    ) {
    }

    public function login(string $login, string $password)
    {
        $user = $this->userRepository->findOneBy([
            'login' => $login,
        ]);
        return $this->jwtManager->create($user);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->findOneBy([
            'login' => $request->login,
        ]);
        if ($user) {
            throw new ServiceException('USER_ALREADY_EXISTS');
        }

        $user = new User();
        $user->setLogin($request->login);
        $user->setName($request->name);
        $user->setSurname($request->surname);

        $hash = $this->passwordHasher->hashPassword($user, $request->password);

        $user->setPassword($hash);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function getToken(User $user)
    {

    }
}
