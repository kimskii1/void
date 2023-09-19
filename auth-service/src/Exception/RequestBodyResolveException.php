<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestBodyResolveException extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        $message = 'Error while unmarshalling request body';
        parent::__construct('ERR_BODY_RESOLVE: ' . $previous->getMessage() ?? $message, 0, $previous);
    }
}
