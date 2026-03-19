<?php

namespace Ocore\exceptions;

use Ocore\exceptions\BaseException;

class NotFoundException extends BaseException
{
    public function __construct(string $message = "Page/Resource nt found", $code = null)
    {
        parent::__construct($message, 404, $code);
        http_response_code(404);
    }
}