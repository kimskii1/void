<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException
{
    public function __construct(private ConstraintViolationListInterface $violations)
    {
        parent::__construct('ERR_VALIDATION_FAILED');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
