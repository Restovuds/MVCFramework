<?php

namespace Ocore\exceptions;

abstract class BaseException
{
    protected string $message {
        get {
            return $this->message;
        }
    }
    public int $statusCode;
    protected int|string|null $code {
        get {
            return $this->code;
        }
    }

    public function __construct($message = 'Error', $statusCode = 400, $code = null)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->code = $code;
    }

    public function __toString(): string
    {
        return
            "<strong>
                <h1>{$this->statusCode}</h1>
                <h2>{$this->message}</h2>
                <h3>{$this->code}</h3>
            </strong>>";
    }
}