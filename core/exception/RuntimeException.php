<?php

namespace Ocore\exception;

class RuntimeException extends \RuntimeException
{
    public function __construct(string $message = "Runtime Exception", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}