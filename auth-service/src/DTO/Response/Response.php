<?php

declare(strict_types=1);

namespace App\DTO\Response;

class Response
{
    public function __construct(
        public mixed $data,
        public bool $success = true
    ) {
    }
}
