<?php

namespace Ocore\exception;

use Throwable;

class ValidatorException extends BaseException
{
    private const string ERROR_NAME = "Validation Error";
    public function __construct(string $message = "Invalid validator", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
