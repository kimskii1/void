<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/api/v1/test', name: 'user.test', methods: ['GET'])]
    public function register(): JsonResponse
    {
        dd($this->getUser());
        return $this->json([
            'test' => 'test',
        ]);
    }
}
