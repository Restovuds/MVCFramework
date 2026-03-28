<?php

namespace Ocore;

class Response
{
    public int $statusCode = 200;

    public function setStatusCode(int $code): void
    {
        $this->statusCode = $code;
        http_response_code($code);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function redirect(string $url = ''): never
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = $_SERVER['HTTP_REFERER'] ?? base_url();
        }

        header("Location: $redirect");
        die;
    }
}