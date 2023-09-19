<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestQueryResolveException extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        $message = 'Error while unmarshalling query params';

        parent::__construct('ERR_QUERY_RESOLVER: ' . $previous->getMessage() ?? $message, 0, $previous);
    }
}
