<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected $context = [];

    public function __construct(string $message, int $code, array $context = [])
    {
        parent::__construct($message, $code);
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
