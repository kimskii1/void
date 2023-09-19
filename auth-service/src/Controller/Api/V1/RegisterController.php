<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\ArgumentResolver\Body;
use App\DTO\Request\LoginRequest;
use App\DTO\Request\RegisterRequest;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

//    #[Route('/api/v1/login', name: 'auth.login', methods: ['POST'])]
//    public function login(#[Body] LoginRequest $request): JsonResponse
//    {
//        return $this->json([
//            'token' => $this->authService->login($request->login, $request->password)
//        ]);
//    }

    #[Route('/api/v1/register', name: 'auth.register', methods: ['POST'])]
    public function register(#[Body] RegisterRequest $request): JsonResponse
    {
        $this->authService->register($request);
        return $this->json([]);
    }

    #[Route('/api/v1/test', name: 'auth.test', methods: ['GET'])]
    public function test(CacheInterface $cache): JsonResponse
    {
        $cache->get('item_0', function (ItemInterface $item) {
            $item->tag(['foo', 'bar']);

            return 'debug';
        });

        return $this->json([]);
    }
}
