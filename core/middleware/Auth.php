<?php

namespace Ocore\Middleware;

class Auth
{
    public function handle(): void
    {
        if (!check_auth()) {
            response()->redirect(LOGIN_PAGE);
        }
    }
}
