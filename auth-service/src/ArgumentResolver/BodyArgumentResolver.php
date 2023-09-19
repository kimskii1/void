<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Exception\RequestBodyResolveException;
use App\Exception\ValidationException;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class BodyArgumentResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return count($argument->getAttributes(Body::class, ArgumentMetadata::IS_INSTANCEOF)) > 0;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $serializer = new Serializer([
            new UidNormalizer(),
            new ObjectNormalizer(),
        ]);

        try {
            $model = $serializer->denormalize(
                $request->toArray(),
                $argument->getType()
            );
        } catch (Throwable $throwable) {
            throw new RequestBodyResolveException($throwable);
        }

        $errors = $this->validator->validate($model);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        yield $model;
    }
}
