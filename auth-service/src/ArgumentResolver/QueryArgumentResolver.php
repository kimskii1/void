<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Contract\DTO\RequestQuery;
use App\Exception\RequestQueryResolveException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class QueryArgumentResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator, private SerializerInterface $serializer)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $check = $argument->getAttributes(Query::class, ArgumentMetadata::IS_INSTANCEOF);
        if (count($check) < 1) {
            return false;
        }
        $class = $argument->getType();
        return (new $class()) instanceof RequestQuery;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            $dto = $this->serializer->deserialize(
                json_encode($request->query->all()),
                $argument->getType(),
                JsonEncoder::FORMAT
            );
        } catch (Throwable $throwable) {
            throw new RequestQueryResolveException($throwable);
        }

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        yield $dto;
    }
}
